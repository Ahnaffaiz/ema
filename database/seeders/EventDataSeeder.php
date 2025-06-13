<?php

namespace Database\Seeders;

use App\Models\Host;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class EventDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Hosts
        $hosts = [
            [
                'name' => 'University Event Center',
                'desc' => 'The premier event hosting facility for academic and professional events.',
                'web' => 'https://eventcenter.university.edu',
                'social' => json_encode([
                    'twitter' => '@UniversityEvents',
                    'facebook' => 'UniversityEventCenter',
                    'instagram' => 'university_events'
                ])
            ],
            [
                'name' => 'Tech Conference Hub',
                'desc' => 'Specialized in hosting technology conferences and workshops.',
                'web' => 'https://techconferencehub.com',
                'social' => json_encode([
                    'twitter' => '@TechConHub',
                    'linkedin' => 'tech-conference-hub'
                ])
            ],
            [
                'name' => 'Community Center',
                'desc' => 'A local community center hosting various social and educational events.',
                'web' => 'https://communitycenter.local',
                'social' => json_encode([
                    'facebook' => 'LocalCommunityCenter'
                ])
            ],
            [
                'name' => 'Business Innovation Center',
                'desc' => 'Focused on business networking events and innovation showcases.',
                'web' => 'https://bizcenter.com',
                'social' => json_encode([
                    'linkedin' => 'business-innovation-center',
                    'twitter' => '@BizInnovation'
                ])
            ]
        ];

        foreach ($hosts as $host) {
            Host::create($host);
        }

        // Create Tags
        $tags = [
            ['name' => 'conference'],
            ['name' => 'workshop'],
            ['name' => 'networking'],
            ['name' => 'technology'],
            ['name' => 'business'],
            ['name' => 'education'],
            ['name' => 'training'],
            ['name' => 'seminar'],
            ['name' => 'webinar'],
            ['name' => 'meetup'],
            ['name' => 'hackathon'],
            ['name' => 'exhibition'],
            ['name' => 'social'],
            ['name' => 'fundraising'],
            ['name' => 'startup'],
            ['name' => 'innovation'],
            ['name' => 'leadership'],
            ['name' => 'marketing'],
            ['name' => 'design'],
            ['name' => 'development']
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        $this->command->info('Event data seeded successfully!');
    }
}
