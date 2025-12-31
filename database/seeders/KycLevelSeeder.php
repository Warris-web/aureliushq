<?php

// database/seeders/KycLevelSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KycLevel;

class KycLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            'low' => [
                'title' => 'Low Level Account',
                'description' => '
                    <p>Designed for students, unemployed individuals, or low-income earners. Requires minimal documents (only ID).</p>
                    <p><strong>Credit Limit:</strong> ₦10,000 – ₦50,000</p>
                    <p><strong>Repayment Period:</strong> 30 days</p>
                    <p><strong>Repayment Options:</strong></p>
                    <ul>
                        <li>Weekly: 4 equal weekly installments</li>
                        <li>Semi-Weekly: 2 installments every week (8 total within 30 days)</li>
                        <li>Bi-Weekly: 2 installments every 2 weeks (2 total)</li>
                        <li>Outright: One-time full repayment</li>
                    </ul>',
                'credit_limit' => '₦10,000 – ₦50,000',
                'repayment_period' => '30 days',
                'credit_amount_limit' => 50000,

            ],
            'medium' => [
                'title' => 'Medium Level Account',
                'description' => '
                    <p>For civil servants, teachers, and small business owners with moderate income. Requires ID and proof of address.</p>
                    <p><strong>Credit Limit:</strong> ₦51,000 – ₦200,000</p>
                    <p><strong>Repayment Period:</strong> 30 days</p>
                    <p><strong>Repayment Options:</strong></p>
                    <ul>
                        <li>Weekly: 4 equal weekly installments</li>
                        <li>Semi-Weekly: 2 installments every week (8 total within 30 days)</li>
                        <li>Bi-Weekly: 2 installments every 2 weeks (2 total)</li>
                        <li>Outright: One-time full repayment</li>
                    </ul>',
                'credit_limit' => '₦51,000 – ₦200,000',
                'repayment_period' => '30 days',
                'credit_amount_limit' => 200000,
            ],
            'high' => [
                'title' => 'High Level Account',
                'description' => '
                    <p>For senior civil servants, professionals, and mid-sized business owners. Requires ID, proof of address, and income verification.</p>
                    <p><strong>Credit Limit:</strong> ₦201,000 – ₦500,000+</p>
                    <p><strong>Repayment Period:</strong> 60 days</p>
                    <p><strong>Repayment Options:</strong></p>
                    <ul>
                        <li>Weekly: 4 installments over 8 weeks (8 total)</li>
                        <li>Semi-Weekly: 2 installments every week for 2 months (8 total)</li>
                        <li>Bi-Weekly: 2 installments every 2 weeks (4 total)</li>
                        <li>Monthly: 2 equal monthly payments</li>
                        <li>Outright: One-time full repayment</li>
                    </ul>',
                'credit_limit' => '₦201,000 – ₦500,000+',
                'repayment_period' => '60 days',
                'credit_amount_limit' => 300000,

            ],
            'market_woman' => [
                'title' => 'High Level/Market Trader',
                'description' => '
                    <p>Special verification for traders, food vendors, and small market business owners. Requires simplified documents.</p>
                    <p><strong>Credit Limit:</strong> Flexible (determined by admin based on business size & turnover)</p>
                    <p><strong>Repayment Period:</strong> Daily or weekly, based on user convenience</p>
                    <p><strong>Repayment Options:</strong></p>
                    <ul>
                        <li>Daily: Small, consistent amounts paid every day</li>
                        <li>Weekly: Full weekly installment once every 7 days</li>
                        <li>Semi-Flexible: Payments anytime, but full amount must be completed within 30 days</li>
                    </ul>',
                'credit_limit' => 'Flexible',
                'repayment_period' => 'Daily or Weekly',
                'credit_amount_limit' => 500000,

            ],
        ];

        foreach ($levels as $key => $data) {
            KycLevel::updateOrCreate(
                ['key' => $key], // condition
                $data           // values to update
            );
        }
    }
}
