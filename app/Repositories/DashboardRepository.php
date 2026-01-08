<?php

namespace App\Repositories;

use App\Interfaces\DashboardRepositoryInterface;
use App\Models\Development;
use App\Models\DevelopmentApplicant;
use App\Models\Event;
use App\Models\FamilyMember;
use App\Models\HeadOfFamily;
use App\Models\SocialAssistance;
use App\Models\SocialAssistanceRecipient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getDashboardData()
    {
        $now = Carbon::now();
        $currentMonthStart = $now->copy()->startOfMonth();
        $previousMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $previousMonthEnd = $currentMonthStart->copy()->subSecond();

        $headOfFamiliesCount = HeadOfFamily::count();
        $familyMembersCount = FamilyMember::count();
        $residentsCount = $headOfFamiliesCount + $familyMembersCount;

        $currentResidents = HeadOfFamily::whereBetween('created_at', [$currentMonthStart, $now])->count()
            + FamilyMember::whereBetween('created_at', [$currentMonthStart, $now])->count();
        $previousResidents = HeadOfFamily::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count()
            + FamilyMember::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        $currentDevelopments = Development::whereBetween('created_at', [$currentMonthStart, $now])->count();
        $previousDevelopments = Development::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        $currentEvents = Event::whereBetween('created_at', [$currentMonthStart, $now])->count();
        $previousEvents = Event::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        $currentSocialAssistances = SocialAssistance::whereBetween('created_at', [$currentMonthStart, $now])->count();
        $previousSocialAssistances = SocialAssistance::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        $currentApplicants = DevelopmentApplicant::whereBetween('created_at', [$currentMonthStart, $now])->count();
        $previousApplicants = DevelopmentApplicant::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        $latestRecipients = SocialAssistanceRecipient::with('socialAssistance')
            ->latest()
            ->take(4)
            ->get()
            ->map(function (SocialAssistanceRecipient $recipient) {
                $assistance = $recipient->socialAssistance;
                $type = $assistance ? $this->mapSocialAssistanceType($assistance->category) : 'goods';

                return [
                    'id' => $recipient->id,
                    'title' => $assistance
                        ? ($type === 'money' ? $this->formatRupiah($assistance->amount) : $assistance->name)
                        : null,
                    'type' => $type,
                    'giver_name' => $assistance?->provider,
                    'status' => $this->mapApplicantStatus($recipient->status),
                    'created_at' => $recipient->created_at?->toISOString(),
                ];
            })
            ->values();

        $upcomingEventsQuery = Event::whereDate('date', '>=', $now->toDateString())
            ->orderBy('date')
            ->orderBy('time');

        $upcomingEventsTotal = (clone $upcomingEventsQuery)->count();
        $upcomingEvents = $upcomingEventsQuery
            ->take(1)
            ->get()
            ->map(function (Event $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'image' => $event->thumbnail ? Storage::disk('public')->url($event->thumbnail) : null,
                    'time' => $event->time ? Carbon::parse($event->time)->format('H:i') . ' WIB' : null,
                    'date' => $event->date?->format('Y-m-d'),
                ];
            })
            ->values();

        $weekStart = $now->copy()->startOfWeek(Carbon::MONDAY);
        $weekDays = collect(range(0, 6))->map(function (int $offset) use ($weekStart, $now) {
            $date = $weekStart->copy()->addDays($offset);

            return [
                'date' => $date->day,
                'weekday' => $this->weekdayLabel($date->dayOfWeek),
                'active' => $date->isSameDay($now),
            ];
        });

        $latestApplicants = DevelopmentApplicant::with(['user.headOfFamily', 'user.familyMember', 'development'])
            ->latest()
            ->take(3)
            ->get()
            ->map(function (DevelopmentApplicant $applicant) {
                $user = $applicant->user;
                $avatar = $user?->headOfFamily?->profile_picture ?: $user?->familyMember?->profile_picture;

                return [
                    'id' => $applicant->id,
                    'name' => $user?->name,
                    'avatar' => $avatar ? Storage::disk('public')->url($avatar) : null,
                    'thumbnail' => $applicant->development?->thumbnail
                        ? Storage::disk('public')->url($applicant->development->thumbnail)
                        : null,
                    'submission_title' => $applicant->development
                        ? 'Melamar pembangunan ' . $applicant->development->name
                        : null,
                    'status' => $this->mapApplicantStatus($applicant->status),
                    'created_at' => $applicant->created_at?->toISOString(),
                ];
            })
            ->values();

        $populationStats = $this->buildPopulationStats($now, $residentsCount);

        return [
            'stats' => [
                'residents' => $residentsCount,
                'residents_trend_percent' => $this->trendPercent($currentResidents, $previousResidents),
                'developments' => Development::count(),
                'developments_trend_percent' => $this->trendPercent($currentDevelopments, $previousDevelopments),
                'head_of_families' => $headOfFamiliesCount,
                'head_of_families_trend_percent' => $this->trendPercent(
                    HeadOfFamily::whereBetween('created_at', [$currentMonthStart, $now])->count(),
                    HeadOfFamily::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count()
                ),
                'events' => Event::count(),
                'events_trend_percent' => $this->trendPercent($currentEvents, $previousEvents),
                'social_assistances' => SocialAssistance::count(),
                'social_assistances_trend_percent' => $this->trendPercent($currentSocialAssistances, $previousSocialAssistances),
                'total_applicants' => DevelopmentApplicant::count(),
                'total_applicants_trend_percent' => $this->trendPercent($currentApplicants, $previousApplicants),
            ],
            'social_assistances_latest' => $latestRecipients,
            'events' => [
                'current_month' => $now->format('F'),
                'current_year' => (int) $now->format('Y'),
                'days' => $weekDays,
                'upcoming_total' => $upcomingEventsTotal,
                'upcoming' => $upcomingEvents,
            ],
            'applicants_latest' => $latestApplicants,
            'population_stats' => $populationStats,
        ];
    }

    private function trendPercent(int $current, int $previous): int
    {
        if ($previous === 0) {
            return $current > 0 ? 100 : 0;
        }

        return (int) round((($current - $previous) / $previous) * 100);
    }

    private function formatRupiah($amount): string
    {
        $value = is_numeric($amount) ? (float) $amount : 0;

        return 'Rp' . number_format($value, 0, ',', '.');
    }

    private function mapSocialAssistanceType(?string $category): string
    {
        return $category === 'cash' ? 'money' : 'goods';
    }

    private function mapApplicantStatus(?string $status): ?string
    {
        if ($status === null) {
            return null;
        }

        return $status === 'approved' ? 'accepted' : $status;
    }

    private function weekdayLabel(int $dayOfWeek): string
    {
        return match ($dayOfWeek) {
            Carbon::MONDAY => 'Sen',
            Carbon::TUESDAY => 'Sel',
            Carbon::WEDNESDAY => 'Rab',
            Carbon::THURSDAY => 'Kam',
            Carbon::FRIDAY => 'Jum',
            Carbon::SATURDAY => 'Sab',
            default => 'Min',
        };
    }

    private function buildPopulationStats(Carbon $now, int $totalResidents): array
    {
        $adultCutoff = $now->copy()->subYears(13)->endOfDay();
        $childrenStart = $now->copy()->subYears(12)->startOfDay();
        $childrenEnd = $now->copy()->subYears(6)->endOfDay();
        $toddlersStart = $now->copy()->subYears(5)->startOfDay();

        $adultMaleCount = HeadOfFamily::where('gender', 'male')
            ->whereDate('date_of_birth', '<=', $adultCutoff)
            ->count()
            + FamilyMember::where('gender', 'male')
            ->whereDate('date_of_birth', '<=', $adultCutoff)
            ->count();

        $adultFemaleCount = HeadOfFamily::where('gender', 'female')
            ->whereDate('date_of_birth', '<=', $adultCutoff)
            ->count()
            + FamilyMember::where('gender', 'female')
            ->whereDate('date_of_birth', '<=', $adultCutoff)
            ->count();

        $childrenCount = HeadOfFamily::whereBetween('date_of_birth', [$childrenStart, $childrenEnd])->count()
            + FamilyMember::whereBetween('date_of_birth', [$childrenStart, $childrenEnd])->count();

        $toddlersCount = HeadOfFamily::whereDate('date_of_birth', '>=', $toddlersStart)->count()
            + FamilyMember::whereDate('date_of_birth', '>=', $toddlersStart)->count();

        $adultMaleRange = $this->adultAgeRangeLabel('male', $adultCutoff);
        $adultFemaleRange = $this->adultAgeRangeLabel('female', $adultCutoff);

        return [
            'total' => $totalResidents,
            'segments' => [
                [
                    'label' => 'Pria',
                    'value' => $adultMaleCount,
                    'age_range' => $adultMaleRange,
                ],
                [
                    'label' => 'Wanita',
                    'value' => $adultFemaleCount,
                    'age_range' => $adultFemaleRange,
                ],
                [
                    'label' => 'Anak-anak',
                    'value' => $childrenCount,
                    'age_range' => '6-12 tahun',
                ],
                [
                    'label' => 'Balita',
                    'value' => $toddlersCount,
                    'age_range' => '0-5 tahun',
                ],
            ],
        ];
    }

    private function adultAgeRangeLabel(string $gender, Carbon $adultCutoff): string
    {
        $headRange = HeadOfFamily::where('gender', $gender)
            ->whereDate('date_of_birth', '<=', $adultCutoff)
            ->selectRaw('MIN(date_of_birth) as min_dob, MAX(date_of_birth) as max_dob')
            ->first();

        $memberRange = FamilyMember::where('gender', $gender)
            ->whereDate('date_of_birth', '<=', $adultCutoff)
            ->selectRaw('MIN(date_of_birth) as min_dob, MAX(date_of_birth) as max_dob')
            ->first();

        $oldestDob = $this->minDate($headRange?->min_dob, $memberRange?->min_dob);
        $youngestDob = $this->maxDate($headRange?->max_dob, $memberRange?->max_dob);

        if (!$oldestDob || !$youngestDob) {
            return '0-0 tahun';
        }

        $maxAge = Carbon::parse($oldestDob)->age;
        $minAge = Carbon::parse($youngestDob)->age;

        return "{$minAge}-{$maxAge} tahun";
    }

    private function minDate(?string $first, ?string $second): ?string
    {
        if (!$first) {
            return $second;
        }

        if (!$second) {
            return $first;
        }

        return Carbon::parse($first)->lessThan(Carbon::parse($second)) ? $first : $second;
    }

    private function maxDate(?string $first, ?string $second): ?string
    {
        if (!$first) {
            return $second;
        }

        if (!$second) {
            return $first;
        }

        return Carbon::parse($first)->greaterThan(Carbon::parse($second)) ? $first : $second;
    }
}
