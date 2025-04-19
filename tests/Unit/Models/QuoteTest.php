<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    use RefreshDatabase;

    protected Role $role;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup reusable Role instance
        $this->role = $this->createRole();
    }

    /**
     * Helper method to create a Quote instance with related data.
     */
    private function createQuote(array $quoteData = [], array $userData = [], array $companyData = []): Quote
    {
        $user = $this->createUser($userData);

        $companyData = array_merge([
            'name' => 'Default Company',
            'primary_contact_name' => 'Company Contact',
            'primary_contact_email' => 'company@email.com',
            'account_manager_id' => $user->id,
        ], $companyData);

        $company = Company::create($companyData);

        return Quote::create(array_merge([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'status' => 'draft',
            'quote_name' => 'Test Quote',
        ], $quoteData));
    }

    /**
     * Helper method to create multiple QuoteItems for a Quote.
     */
    private function createQuoteItems(Quote $quote, array $items = []): void
    {
        foreach ($items as $item) {
            QuoteItem::create(array_merge(['quote_id' => $quote->id], $item));
        }
    }

    /**
     * Helper to create a role.
     */
    protected function createRole(array $attributes = []): Role
    {
        return Role::create(array_merge([
            'name' => 'user',
            'description' => 'user description',
            'level' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ], $attributes));
    }

    /**
     * Helper to create a user.
     */
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'role_id' => $this->role->id,
        ], $attributes));
    }

    public function test_it_has_a_relationship_with_user()
    {
        $quote = $this->createQuote();

        $this->assertInstanceOf(User::class, $quote->user);
        $this->assertEquals($quote->user_id, $quote->user->id);
    }

    public function test_it_has_a_relationship_with_company()
    {
        $quote = $this->createQuote();

        $this->assertInstanceOf(Company::class, $quote->company);
        $this->assertEquals($quote->company_id, $quote->company->id);
    }

    public function test_it_has_a_relationship_with_quote_items()
    {
        $quote = $this->createQuote();
        $this->createQuoteItems($quote, [
            [
                'name' => 'Item 1',
                'description' => 'Description 1',
                'product_source' => 'Warehouse',
                'quantity' => 2,
                'unit_buy_price' => 10,
                'total_buy_price' => 20,
                'unit_sell_price' => 15,
                'total_sell_price' => 30,
            ],
            [
                'name' => 'Item 2',
                'description' => 'Description 2',
                'product_source' => 'Warehouse',
                'quantity' => 1,
                'unit_buy_price' => 25,
                'total_buy_price' => 25,
                'unit_sell_price' => 40,
                'total_sell_price' => 40,
            ],
        ]);

        $this->assertCount(2, $quote->products);
    }

    public function test_it_calculates_total_sell_price_correctly()
    {
        $quote = $this->createQuote();
        $this->createQuoteItems($quote, [
            [
                'name' => 'Item 1',
                'description' => 'Description 1',
                'product_source' => 'Warehouse',
                'quantity' => 2,
                'unit_buy_price' => 10,
                'total_buy_price' => 20,
                'unit_sell_price' => 50,
                'total_sell_price' => 100,
            ],
            [
                'name' => 'Item 2',
                'description' => 'Description 2',
                'product_source' => 'Warehouse',
                'quantity' => 1,
                'unit_buy_price' => 25,
                'total_buy_price' => 25,
                'unit_sell_price' => 50,
                'total_sell_price' => 50,
            ],
        ]);

        $this->assertEquals(150, $quote->total_sell_price);
    }
}
