<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Custom Software',
                'icon' => 'ri-code-box-line',
                'short_description' => 'Tailored platforms, internal tools and APIs built around your workflows.',
                'description' => "We build software that fits the way your business actually works, from first prototype to production-ready platform. Our team handles architecture, development and testing so you can focus on your customers.\n\n- Web platforms and customer portals\n- Internal tools and dashboards\n- API design and system integrations",
            ],
            [
                'title' => 'Web and Mobile Apps',
                'icon' => 'ri-smartphone-line',
                'short_description' => 'Fast, accessible interfaces for browsers, iOS and Android.',
                'description' => "We create responsive web apps and native or cross-platform mobile apps that feel smooth and are easy to use. Performance, accessibility and a consistent experience across devices are built in from day one.\n\n- Progressive and single-page web apps\n- iOS and Android apps\n- Performance and accessibility audits",
            ],
            [
                'title' => 'Cloud and DevOps',
                'icon' => 'ri-cloud-line',
                'short_description' => 'Migration, infrastructure as code and CI/CD pipelines that keep releases smooth.',
                'description' => "We help you move to the cloud and run reliably once you are there. Automated pipelines and well-defined infrastructure make releases faster, safer and repeatable.\n\n- Cloud migration and architecture\n- Infrastructure as code\n- CI/CD, monitoring and cost optimisation",
            ],
            [
                'title' => 'AI and Data',
                'icon' => 'ri-robot-2-line',
                'short_description' => 'Analytics, automation and machine learning that turn data into decisions.',
                'description' => "We turn the data you already have into useful features, from reporting dashboards to automation and machine-learning models, with clear measures of success agreed up front.\n\n- Analytics and reporting dashboards\n- Process automation\n- Machine-learning features and chat assistants",
            ],
            [
                'title' => 'UI/UX Design',
                'icon' => 'ri-palette-line',
                'short_description' => 'Research-led design systems and prototypes your users will enjoy.',
                'description' => "We combine user research with clean visual design to create interfaces people understand at a glance. You get tested prototypes and a reusable design system your team can keep building on.\n\n- User research and journey mapping\n- Wireframes and interactive prototypes\n- Design systems and developer handoff",
            ],
            [
                'title' => 'Security and QA',
                'icon' => 'ri-shield-check-line',
                'short_description' => 'Security reviews, testing and monitoring to keep your product dependable.',
                'description' => "We make quality and security part of every release. Automated tests, careful reviews and ongoing monitoring help you catch problems before your users do.\n\n- Manual and automated testing\n- Security reviews and hardening\n- Monitoring and incident readiness",
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['title' => $service['title']],
                $service
            );
        }
    }
}
