<script>
    import { onDestroy, onMount } from 'svelte';
    import SectionTitle from '../ui/SectionTitle.svelte';
    import { gsap, ScrollTrigger } from '../../lib/gsap';

    let section = $state(null);
    let line = $state(null);
    let nodes = $state([]);
    let triggers = $state([]);

    const entries = [
        {
            date: '2025–2026',
            role: 'Vice Mayor',
            org: 'Google Developer Groups on Campus - UIC',
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
            org: 'VIBE Club - UIC',
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
            points: [
                'Designed and facilitated DIGISKWELA digital literacy and game development workshops for 54 Grade 6 students.',
                'Coordinated responsible digital citizenship seminars for student and community participants.',
                'Spearheaded extension projects with CCS and partner student organizations for outreach and school support.',
                'Led facilitator teams in planning schedules, safety procedures, and teaching materials.',
                'Collected participant and teacher feedback to improve future civic engagement programs.',
            ],
        },
    ];

    $effect(() => {
        entries.length;
    });

    onMount(() => {
        if (!section || !line) return;

        gsap.set(line, { scaleY: 0, transformOrigin: 'top' });

        triggers.push(
            ScrollTrigger.create({
                trigger: section,
                start: 'top 70%',
                end: 'bottom 80%',
                scrub: true,
                onUpdate: (self) => gsap.to(line, { scaleY: self.progress, duration: 0.1, overwrite: true }),
            })
        );

        nodes.forEach((node) => {
            gsap.set(node, { scale: 0 });
            triggers.push(
                ScrollTrigger.create({
                    trigger: node,
                    start: 'top 82%',
                    onEnter: () => gsap.to(node, { scale: 1, duration: 0.45, ease: 'back.out(2)' }),
                    once: true,
                })
            );
        });
    });

    onDestroy(() => {
        triggers.forEach((t) => t.kill());
    });
</script>

<section id="leadership" class="section-wrap relative isolate overflow-hidden" bind:this={section}>
    <div class="section-grid-zoom" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto w-full max-w-6xl px-6">
        <SectionTitle number="04" title="Leadership" subtitle="A timeline of student leadership roles focused on technical growth, organization, and community impact." />

        <div class="relative pl-10">
            <div bind:this={line} class="absolute left-3 top-0 h-full w-[2px] bg-[var(--color-primary)]/70"></div>

            <div class="space-y-10">
                {#each entries as entry, i}
                    <article class="relative rounded-2xl border border-[var(--color-primary)]/30 bg-[var(--color-surface)] p-6">
                        <span bind:this={nodes[i]} class="absolute -left-[1.96rem] top-7 h-4 w-4 rounded-full border-2 border-[var(--color-primary)] bg-[var(--color-bg)]"></span>
                        <span class="inline-flex rounded-full bg-[var(--color-warm)]/20 px-3 py-1 text-xs font-mono text-[var(--color-warm)]">{entry.date}</span>
                        <h3 class="font-display mt-4 text-2xl">{entry.role}</h3>
                        <p class="mt-1 text-sm text-[var(--color-muted)]">{entry.org}</p>
                        <ul class="mt-4 space-y-2 text-sm text-[var(--color-text)]/90">
                            {#each entry.points as point}
                                <li>• {point}</li>
                            {/each}
                        </ul>
                    </article>
                {/each}
            </div>
        </div>
    </div>
</section>
