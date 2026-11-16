<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use JeffersonGoncalves\Lgpd\Attributes\PersonalData;
use JeffersonGoncalves\LgpdRetention\Facades\LgpdRetention;
use JeffersonGoncalves\LgpdRetention\Models\Tombstone;
use JeffersonGoncalves\LgpdRetention\Tests\Fixtures\Contract;
use JeffersonGoncalves\LgpdRetention\Tests\Fixtures\Customer;

function customer(): Customer
{
    return Customer::create(['name' => 'Maria', 'email' => 'maria@example.com', 'tax_id' => '123', 'notes' => 'vip']);
}

it('anonymizes each column only once its own period has ended', function () {
    $customer = customer();

    $this->travel(13)->months();
    LgpdRetention::apply();
    $customer->refresh();

    expect($customer->name)->toBe('M****')
        ->and($customer->email)->toBe('maria@example.com');

    $this->travel(12)->months();
    LgpdRetention::apply();
    $customer->refresh();

    expect($customer->email)->toBe(hash_hmac('sha256', 'maria@example.com', config('app.key')))
        ->and($customer->tax_id)->toBe('123')
        ->and($customer->notes)->toBe('vip'); // no retention declared
});

it('nullifies Keep columns when their retention ends', function () {
    $customer = customer();

    $this->travel(61)->months();
    LgpdRetention::apply();

    expect($customer->fresh()->tax_id)->toBeNull();
});

it('never anonymizes the same column twice', function () {
    $customer = customer();
    $this->travel(3)->years();

    LgpdRetention::apply();
    $hash = $customer->fresh()->email;
    $report = LgpdRetention::apply();

    expect($customer->fresh()->email)->toBe($hash)
        ->and(collect($report)->sum('records'))->toBe(0)
        ->and(Tombstone::count())->toBe(2);
});

it('counts without touching anything on a dry run', function () {
    customer();
    $this->travel(13)->months();

    Artisan::call('lgpd:retention', ['--dry-run' => true]);

    expect(Artisan::output())->toContain('Would anonymize')
        ->and(Customer::first()->name)->toBe('Maria')
        ->and(Tombstone::count())->toBe(0);
});

it('counts from a custom start column and skips rows where it is null', function () {
    $ended = Contract::create(['signer' => 'Ana', 'ended_at' => now()]);
    $running = Contract::create(['signer' => 'Bia', 'ended_at' => null]);

    $this->travel(13)->months();
    LgpdRetention::apply();

    expect($ended->fresh()->signer)->toBeNull()
        ->and($running->fresh()->signer)->toBe('Bia');
});

it('re-anonymizes data restored from a backup, once', function () {
    $customer = customer();
    $this->travel(3)->years();
    LgpdRetention::apply();
    $anonymized = $customer->fresh()->only('name', 'email');

    // Backup restore brings the original values back.
    DB::table('customers')->where('id', $customer->id)->update(['name' => 'Maria', 'email' => 'maria@example.com']);

    expect(LgpdRetention::reapply())->toBe(2)
        ->and($customer->fresh()->only('name', 'email'))->toBe($anonymized)
        ->and(LgpdRetention::reapply())->toBe(0);
});

it('tombstones any anonymization (e.g. DSAR erasure) so a backup restore is erased again', function () {
    $customer = customer();
    $customer->anonymizePersonalData(); // what laravel-lgpd-dsar erase() does
    $erased = $customer->fresh()->only('name', 'email', 'notes');

    expect(Tombstone::pluck('column')->sort()->values()->all())->toBe(['email', 'name', 'notes']); // not tax_id (Keep)

    DB::table('customers')->where('id', $customer->id)->update(['name' => 'Maria', 'email' => 'maria@example.com', 'notes' => 'vip']);

    expect(LgpdRetention::reapply())->toBe(3)
        ->and($customer->fresh()->only('name', 'email', 'notes'))->toBe($erased);

    // The Keep column the erasure spared still expires with its retention; erased columns are not touched again.
    $this->travel(61)->months();
    LgpdRetention::apply();

    expect($customer->fresh()->tax_id)->toBeNull()
        ->and($customer->fresh()->email)->toBe($erased['email']);
});

it('rejects an invalid retention period', function () {
    config()->set('lgpd.models', [BrokenRetention::class]);

    LgpdRetention::apply();
})->throws(InvalidArgumentException::class, 'Invalid retention');

#[PersonalData('name', retention: 'forever')]
class BrokenRetention extends Customer
{
    protected $table = 'customers';
}
