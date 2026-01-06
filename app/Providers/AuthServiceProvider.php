<?php

namespace App\Providers;

use App\Models\DevelopmentApplicant;
use App\Models\EventParticipant;
use App\Models\FamilyMember;
use App\Models\HeadOfFamily;
use App\Models\Profile;
use App\Models\SocialAssistanceRecipient;
use App\Policies\DevelopmentApplicantPolicy;
use App\Policies\EventParticipantPolicy;
use App\Policies\FamilyMemberPolicy;
use App\Policies\HeadOfFamilyPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\SocialAssistanceRecipientPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        DevelopmentApplicant::class => DevelopmentApplicantPolicy::class,
        HeadOfFamily::class => HeadOfFamilyPolicy::class,
        FamilyMember::class => FamilyMemberPolicy::class,
        SocialAssistanceRecipient::class => SocialAssistanceRecipientPolicy::class,
        EventParticipant::class => EventParticipantPolicy::class,
        Profile::class => ProfilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
