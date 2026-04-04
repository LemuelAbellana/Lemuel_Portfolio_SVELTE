<script>
    import SectionTitle from '../ui/SectionTitle.svelte';

    const entries = [
        {
            date: '2025–2026',
            role: 'Vice Mayor',
            org: 'Google Developer Groups on Campus - UIC',
            logo: '/assets/images/gdglogo.png',
            position: 'left',
            useAvatar: true,
            points: [
                'Co-led planning and execution of seminars and workshops with the club lead.',
                'Prepared activity plans, budget requests, and liquidation documentation.',
                'Conducted GDGOC-UIC InfoSession for membership and program orientation.',
                'Collaborated with partner communities including DICE, USEP-DSC, UP SPARCS, and SPACE Davao.',
            ],
        },
        {
            date: '2023–2024',
            role: 'Club Mayor',
            org: 'Virtual Initiative for Building Engagement - UIC',
            logo: '/assets/images/vibelogo.png',
            position: 'right',
            useAvatar: false,
            points: [
                'Facilitated student development seminars and engagement activities.',
                'Led planning and coordination for News/Feature Writing and Filmmaking/Video Production sessions.',
                'Helped strengthen creative and communication skills in the student community.',
            ],
        },
        {
            date: '2023–2024',
            role: 'UIC-CCS Leader / Spearheader',
            org: 'NSTP-CWTS',
            logo: '/assets/images/ccslogo.png',
            position: 'left',
            useAvatar: false,
            points: [
                'Designed and facilitated DIGISKWELA digital literacy and game development workshops for 54 Grade 6 students.',
                'Coordinated responsible digital citizenship seminars for student and community participants.',
                'Spearheaded extension projects with CCS and partner student organizations for outreach and school support.',
                'Led facilitator teams in planning schedules, safety procedures, and teaching materials.',
                'Collected participant and teacher feedback to improve future civic engagement programs.',
            ],
        },
    ];

    const viceMayorAvatar =
        'https://api.dicebear.com/9.x/adventurer/svg?seed=vice-mayor-uic&backgroundColor=ffe0b2,d1d4f9,b6e3f4&radius=16';

    $effect(() => {
        entries.length;
    });
</script>

<section id="leadership" class="section-wrap relative isolate overflow-hidden">
    <div class="section-grid-zoom" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto w-full max-w-6xl px-6">
        <SectionTitle number="04" title="Leadership" subtitle="A timeline of student leadership roles focused on technical growth, organization, and community impact." />

        <div class="space-y-8 md:space-y-10">
            {#each entries as entry}
                <article class={`leader-row ${entry.position === 'right' ? 'leader-row-right' : 'leader-row-left'}`}>
                    <div class="leader-visual">
                        {#if entry.useAvatar}
                            <div class="avatar-shell">
                                <img src={viceMayorAvatar} alt="3D avatar for vice mayor role" loading="lazy" class="avatar-image" />
                            </div>
                        {/if}

                        <div class="logo-shell">
                            <img src={entry.logo} alt={`${entry.role} organization logo`} loading="lazy" class="logo-image" />
                        </div>
                    </div>

                    <div class="leader-card">
                        <span class="inline-flex rounded-full bg-[var(--color-warm)]/20 px-3 py-1 text-xs font-mono text-[var(--color-warm)]">{entry.date}</span>
                        <h3 class="font-display mt-4 text-2xl">{entry.role}</h3>
                        <p class="mt-1 text-sm text-[var(--color-muted)]">{entry.org}</p>
                        <ul class="mt-4 space-y-2 text-sm text-[var(--color-text)]/90">
                            {#each entry.points as point}
                                <li>• {point}</li>
                            {/each}
                        </ul>
                    </div>
                </article>
            {/each}
        </div>
    </div>
</section>

<style>
    .leader-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 1rem;
        align-items: center;
    }

    .leader-visual {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        justify-content: center;
    }

    .logo-shell {
        height: 5rem;
        width: 5rem;
        border-radius: 1.2rem;
        display: grid;
        place-items: center;
        border: 1px solid color-mix(in srgb, var(--color-primary) 45%, transparent);
        background: color-mix(in srgb, var(--color-surface) 90%, transparent);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .logo-image {
        max-height: 3.35rem;
        max-width: 3.35rem;
        object-fit: contain;
    }

    .avatar-shell {
        height: 5rem;
        width: 5rem;
        border-radius: 1.2rem;
        overflow: hidden;
        border: 1px solid color-mix(in srgb, var(--color-primary) 45%, transparent);
        background: linear-gradient(145deg, rgba(18, 21, 34, 0.95), rgba(44, 30, 62, 0.88));
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.3);
    }

    .avatar-image {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .leader-card {
        border-radius: 1rem;
        border: 1px solid color-mix(in srgb, var(--color-primary) 35%, transparent);
        background: color-mix(in srgb, var(--color-surface) 92%, black 8%);
        padding: 1.3rem;
    }

    @media (min-width: 768px) {
        .leader-row {
            grid-template-columns: 0.9fr 1.1fr;
            gap: 1.2rem;
        }

        .leader-row-right {
            grid-template-columns: 1.1fr 0.9fr;
        }

        .leader-row-right .leader-visual {
            order: 2;
        }

        .leader-row-right .leader-card {
            order: 1;
        }

        .leader-row-left .leader-visual {
            order: 1;
        }

        .leader-row-left .leader-card {
            order: 2;
        }

        .leader-visual {
            justify-content: flex-start;
        }

        .leader-row-right .leader-visual {
            justify-content: flex-end;
        }

        .logo-shell,
        .avatar-shell {
            height: 6.5rem;
            width: 6.5rem;
        }

        .logo-image {
            max-height: 4.4rem;
            max-width: 4.4rem;
        }

        .leader-card {
            padding: 1.5rem;
        }
    }
</style>
