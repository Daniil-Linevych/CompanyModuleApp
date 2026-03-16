<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class CompanyFixtures extends Fixture
{
    public const COMPANY_APPLE     = 'company-apple';
    public const COMPANY_GOOGLE    = 'company-google';
    public const COMPANY_NETFLIX   = 'company-netflix';
    public const COMPANY_SPOTIFY   = 'company-spotify';
    public const COMPANY_AIRBNB    = 'company-airbnb';
    public const COMPANY_TESLA     = 'company-tesla';
    public const COMPANY_NVIDIA    = 'company-nvidia';
    public const COMPANY_MICROSOFT = 'company-microsoft';

    private const COMPANIES = [
        [
            'name'        => 'Apple Inc.',
            'industry'    => 'Consumer Electronics',
            'foundedYear' => 1976,
            'reference'   => self::COMPANY_APPLE,
        ],
        [
            'name'        => 'Google LLC',
            'industry'    => 'Internet & Software',
            'foundedYear' => 1998,
            'reference'   => self::COMPANY_GOOGLE,
        ],
        [
            'name'        => 'Netflix Inc.',
            'industry'    => 'Entertainment',
            'foundedYear' => 1997,
            'reference'   => self::COMPANY_NETFLIX,
        ],
        [
            'name'        => 'Spotify AB',
            'industry'    => 'Music Streaming',
            'foundedYear' => 2006,
            'reference'   => self::COMPANY_SPOTIFY,
        ],
        [
            'name'        => 'Airbnb Inc.',
            'industry'    => 'Travel & Hospitality',
            'foundedYear' => 2008,
            'reference'   => self::COMPANY_AIRBNB,
        ],
        [
            'name'        => 'Tesla Inc.',
            'industry'    => 'Electric Vehicles',
            'foundedYear' => 2003,
            'reference'   => self::COMPANY_TESLA,
        ],
        [
            'name'        => 'NVIDIA Corporation',
            'industry'    => 'Semiconductors',
            'foundedYear' => 1993,
            'reference'   => self::COMPANY_NVIDIA,
        ],
        [
            'name'        => 'Microsoft Corporation',
            'industry'    => 'Software & Cloud',
            'foundedYear' => 1975,
            'reference'   => self::COMPANY_MICROSOFT,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::COMPANIES as $data) {
            $company = new Company();
            $company->setName($data['name']);
            $company->setIndustry($data['industry']);
            $company->setFoundedYear($data['foundedYear']);

            $manager->persist($company);
            $this->addReference($data['reference'], $company);
        }

        $manager->flush();
    }
}
