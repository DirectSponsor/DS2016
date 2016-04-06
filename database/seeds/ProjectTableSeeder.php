<?php

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;
use App\Process\Support\Manager as SupportManager;


class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Paul McGarry', 'role' => 'Administrator', 'projectId' => 0],

            ['name' => 'Coord One', 'role' => 'Coordinator', 'projectId' => 1],
            ['name' => 'Recp One', 'role' => 'Recipient', 'projectId' => 1],
            ['name' => 'Recp Two', 'role' => 'Recipient', 'projectId' => 1],
            ['name' => 'Recp Three', 'role' => 'Recipient', 'projectId' => 1],
            ['name' => 'Recp Four', 'role' => 'Recipient', 'projectId' => 1],
            ['name' => 'Spon One', 'role' => 'Sponsor', 'projectId' => 1],
            ['name' => 'Spon Two', 'role' => 'Sponsor', 'projectId' => 1],
            ['name' => 'Spon Three', 'role' => 'Sponsor', 'projectId' => 1],
            ['name' => 'Spon Four', 'role' => 'Sponsor', 'projectId' => 1],

            ['name' => 'Coord A', 'role' => 'Coordinator', 'projectId' => 2],
            ['name' => 'Recp A', 'role' => 'Recipient', 'projectId' => 2],
            ['name' => 'Recp B', 'role' => 'Recipient', 'projectId' => 2],
            ['name' => 'Recp C', 'role' => 'Recipient', 'projectId' => 2],
            ['name' => 'Recp D', 'role' => 'Recipient', 'projectId' => 2],
            ['name' => 'Spon A', 'role' => 'Sponsor', 'projectId' => 2],
            ['name' => 'Spon B', 'role' => 'Sponsor', 'projectId' => 2],
            ['name' => 'Spon C', 'role' => 'Sponsor', 'projectId' => 2],
            ['name' => 'Spon D', 'role' => 'Sponsor', 'projectId' => 2],
        ];

        $projects = [
            [
                'name' => 'Kenyan Project 1',
                'status' => 'Open',
                'initial_target_euro_budget' => 2000,
                'currency_conversion_factor' => 110,
                'local_currency' => 'Kenyan Schillings',
                'local_currency_symbol' => 'KSh',
                'max_recipients' => 12,
                'max_sponsors' => 20,
                'min_local_amount_retained_recipient' => 100,
                'min_euro_amount_per_recipient' => 10,
                'url' => 'kenyanproject1',
                'description' => 'General description - Kenyan Perma-culture.'
            ],
            [
                'name' => 'Namibia Project 2',
                'status' => 'Budget Building',
                'initial_target_euro_budget' => 2500,
                'currency_conversion_factor' => 16,
                'local_currency' => 'Namibian Dollar',
                'local_currency_symbol' => 'NAD',
                'max_recipients' => 12,
                'max_sponsors' => 15,
                'min_local_amount_retained_recipient' => 100,
                'min_euro_amount_per_recipient' => 10,
                'url' => 'kenyanproject2',
                'description' => 'General description - Namibian Perma-culture.'
            ]
        ];

        foreach ($projects as $project) {
            $this->addProject($project);
        }
        $dbProjects = Project::all();
        foreach ($dbProjects as $dbProject) {
            $dbProject->save();

            foreach ($users as $userRow) {
                if ($userRow['projectId'] != $dbProject->id) {
                    continue;
                }
                $user = User::where('name', $userRow['name'])->first();
                $userRole = $user->userRoles()->first();
                if ($dbProject->status == 'Budget Building') {
                    if ($userRole->role_type == 'Recipient') {
                        continue;
                    }
                }
                $dbProject->addMemberToProject($userRole);
            }

            $amt = 10;
            foreach($dbProject->getSponsors()->take(2) as $sponsor) {
                $amt += 30;
                $sponsorManager = new SupportManager($dbProject);
                $sponsorManager->createSupportedRecipient($sponsor->userRole->user, $amt);
            }
        }
    }

    public function addProject($project) {
        DB::table('project')->insert([
            'name' => $project['name'],
            'status' => $project['status'],
            'max_recipients' => $project['max_recipients'],
            'max_sponsors' => $project['max_sponsors'],
            'initial_target_euro_budget' => $project['initial_target_euro_budget'],
            'currency_conversion_factor' => $project['currency_conversion_factor'],
            'min_local_amount_retained_recipient' => $project['min_local_amount_retained_recipient'],
            'local_currency' => $project['local_currency'],
            'local_currency_symbol' => $project['local_currency_symbol'],
            'min_euro_amount_per_recipient' => $project['min_euro_amount_per_recipient'],
            'url' => $project['url'],
            'description' => $project['description'],
            'updated_by' => 1,
        ]);

    }
}
