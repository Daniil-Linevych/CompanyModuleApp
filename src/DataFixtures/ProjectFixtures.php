<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Employee;
use App\Entity\Project;
use App\Enum\ProjectStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    private const PROJECTS = [
        [
            'title'       => 'iPhone 17 Development',
            'description' => 'Next generation iPhone hardware and software development.',
            'startDate'   => '2024-01-15',
            'status'      => ProjectStatus::IN_PROGRESS,
            'company'     => CompanyFixtures::COMPANY_APPLE,
            'employees'   => [
                EmployeeFixtures::EMPLOYEE_TIM,
            ],
        ],
        [
            'title'       => 'Gemini AI Platform',
            'description' => 'Large language model research and productization.',
            'startDate'   => '2023-06-01',
            'status'      => ProjectStatus::IN_PROGRESS,
            'company'     => CompanyFixtures::COMPANY_GOOGLE,
            'employees'   => [
                EmployeeFixtures::EMPLOYEE_SUNDAR,
            ],
        ],
        [
            'title'       => 'Streaming Quality Optimization',
            'description' => 'Improve adaptive bitrate streaming across all devices.',
            'startDate'   => '2023-09-10',
            'status'      => ProjectStatus::COMPLETED,
            'company'     => CompanyFixtures::COMPANY_NETFLIX,
            'employees'   => [
                EmployeeFixtures::EMPLOYEE_REED,
            ],
        ],
        [
            'title'       => 'Spotify HiFi Launch',
            'description' => 'Lossless audio streaming tier rollout.',
            'startDate'   => '2024-02-20',
            'status'      => ProjectStatus::IN_PROGRESS,
            'company'     => CompanyFixtures::COMPANY_SPOTIFY,
            'employees'   => [
                EmployeeFixtures::EMPLOYEE_DANIEL,
            ],
        ],
        [
            'title'       => 'Airbnb Rooms Feature',
            'description' => 'New product for shared living space rentals.',
            'startDate'   => '2023-11-01',
            'status'      => ProjectStatus::IN_PROGRESS,
            'company'     => CompanyFixtures::COMPANY_AIRBNB,
            'employees'   => [
                EmployeeFixtures::EMPLOYEE_BRIAN,
            ],
        ],
        [
            'title'       => 'Autopilot v5',
            'description' => 'Full self-driving software rewrite using neural networks.',
            'startDate'   => '2024-03-01',
            'status'      => ProjectStatus::IN_PROGRESS,
            'company'     => CompanyFixtures::COMPANY_TESLA,
            'employees'   => [
                EmployeeFixtures::EMPLOYEE_ELON,
            ],
        ],
        [
            'title'       => 'Blackwell GPU Architecture',
            'description' => 'Next-gen GPU architecture for AI workloads.',
            'startDate'   => '2023-07-15',
            'status'      => ProjectStatus::COMPLETED,
            'company'     => CompanyFixtures::COMPANY_NVIDIA,
            'employees'   => [
                EmployeeFixtures::EMPLOYEE_JENSEN,
            ],
        ],
        [
            'title'       => 'Azure AI Services',
            'description' => 'Enterprise AI and machine learning cloud platform.',
            'startDate'   => '2024-01-01',
            'status'      => ProjectStatus::IN_PROGRESS,
            'company'     => CompanyFixtures::COMPANY_MICROSOFT,
            'employees'   => [
                EmployeeFixtures::EMPLOYEE_SATYA,
            ],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROJECTS as $data) {
            /** @var Company $company */
            $company = $this->getReference($data['company'], Company::class);

            $project = new Project();
            $project->setTitle($data['title']);
            $project->setDescription($data['description']);
            $project->setStartDate(new \DateTime($data['startDate']));
            $project->setStatus($data['status']);
            $project->setCompany($company);

            foreach ($data['employees'] as $employeeRef) {
                /** @var Employee $employee */
                $employee = $this->getReference($employeeRef, Employee::class);
                $project->addEmployee($employee);
            }

            $manager->persist($project);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
            EmployeeFixtures::class,
        ];
    }
}
