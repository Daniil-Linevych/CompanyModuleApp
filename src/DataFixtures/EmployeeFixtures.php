<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Employee;
use App\Entity\User;
use App\Enum\EmployeePosition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class EmployeeFixtures extends Fixture implements DependentFixtureInterface
{
    public const EMPLOYEE_TIM     = 'employee-tim';
    public const EMPLOYEE_SUNDAR  = 'employee-sundar';
    public const EMPLOYEE_REED    = 'employee-reed';
    public const EMPLOYEE_DANIEL  = 'employee-daniel';
    public const EMPLOYEE_BRIAN   = 'employee-brian';
    public const EMPLOYEE_ELON    = 'employee-elon';
    public const EMPLOYEE_JENSEN  = 'employee-jensen';
    public const EMPLOYEE_SATYA   = 'employee-satya';

    private const EMPLOYEES = [
        [
            'firstName' => 'Tim',
            'lastName'  => 'Cook',
            'email'     => 'tim.cook@apple.com',
            'position'  => EmployeePosition::MANAGER,
            'company'   => CompanyFixtures::COMPANY_APPLE,
            'user'      => UserFixtures::USER_TIM,
            'reference' => self::EMPLOYEE_TIM,
        ],
        [
            'firstName' => 'Sundar',
            'lastName'  => 'Pichai',
            'email'     => 'sundar.pichai@google.com',
            'position'  => EmployeePosition::MANAGER,
            'company'   => CompanyFixtures::COMPANY_GOOGLE,
            'user'      => UserFixtures::USER_SUNDAR,
            'reference' => self::EMPLOYEE_SUNDAR,
        ],
        [
            'firstName' => 'Reed',
            'lastName'  => 'Hastings',
            'email'     => 'reed.hastings@netflix.com',
            'position'  => EmployeePosition::DEVELOPER,
            'company'   => CompanyFixtures::COMPANY_NETFLIX,
            'user'      => UserFixtures::USER_REED,
            'reference' => self::EMPLOYEE_REED,
        ],
        [
            'firstName' => 'Daniel',
            'lastName'  => 'Ek',
            'email'     => 'daniel.ek@spotify.com',
            'position'  => EmployeePosition::DEVELOPER,
            'company'   => CompanyFixtures::COMPANY_SPOTIFY,
            'user'      => UserFixtures::USER_DANIEL,
            'reference' => self::EMPLOYEE_DANIEL,
        ],
        [
            'firstName' => 'Brian',
            'lastName'  => 'Chesky',
            'email'     => 'brian.chesky@airbnb.com',
            'position'  => EmployeePosition::DEVELOPER,
            'company'   => CompanyFixtures::COMPANY_AIRBNB,
            'user'      => UserFixtures::USER_BRIAN,
            'reference' => self::EMPLOYEE_BRIAN,
        ],
        [
            'firstName' => 'Elon',
            'lastName'  => 'Musk',
            'email'     => 'elon.musk@tesla.com',
            'position'  => EmployeePosition::DEVELOPER,
            'company'   => CompanyFixtures::COMPANY_TESLA,
            'user'      => UserFixtures::USER_ELON,
            'reference' => self::EMPLOYEE_ELON,
        ],
        [
            'firstName' => 'Jensen',
            'lastName'  => 'Huang',
            'email'     => 'jensen.huang@nvidia.com',
            'position'  => EmployeePosition::DESIGNER,
            'company'   => CompanyFixtures::COMPANY_NVIDIA,
            'user'      => UserFixtures::USER_JENSEN,
            'reference' => self::EMPLOYEE_JENSEN,
        ],
        [
            'firstName' => 'Satya',
            'lastName'  => 'Nadella',
            'email'     => 'satya.nadella@microsoft.com',
            'position'  => EmployeePosition::MANAGER,
            'company'   => CompanyFixtures::COMPANY_MICROSOFT,
            'user'      => UserFixtures::USER_SATYA,
            'reference' => self::EMPLOYEE_SATYA,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::EMPLOYEES as $data) {
            /** @var Company $company */
            $company = $this->getReference($data['company'], Company::class);

            /** @var User $user */
            $user = $this->getReference($data['user'], User::class);

            $employee = new Employee();
            $employee->setFirstName($data['firstName']);
            $employee->setLastName($data['lastName']);
            $employee->setEmail($data['email']);
            $employee->setPosition($data['position']);
            $employee->setCompany($company);
            $employee->setUser($user);

            $manager->persist($employee);
            $this->addReference($data['reference'], $employee);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CompanyFixtures::class,
        ];
    }
}
