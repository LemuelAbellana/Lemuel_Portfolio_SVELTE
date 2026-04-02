<script>
    import { onDestroy, onMount } from 'svelte';
    import { Award, Cpu, Rocket, Star, Trophy, Users } from 'lucide-svelte';
    import SectionTitle from '../ui/SectionTitle.svelte';
    import { gsap, ScrollTrigger } from '../../lib/gsap';

    let section = $state(null);
    let scroller = $state(null);
    let trigger = $state(null);

    const achievements = [
        { title: 'DOST-SEI Scholar 2023-2027', icon: Star },
        { title: 'Top 100 Scholars Leadership Camp Region XI', icon: Trophy },
        { title: 'NASA Space Apps Challenge 2025 Participant', icon: Rocket },
        { title: 'AI Engineering Training - DurianPy Davao', icon: Cpu },
        { title: 'Member - ONSSE', icon: Users },
        { title: 'Member - DOST START', icon: Award },
    ];

    $effect(() => {
        achievements.length;
    });

    onMount(() => {
        if (!section || !scroller) return;

        trigger = ScrollTrigger.create({
            trigger: section,
            start: 'top 85%',
            end: 'bottom top',
            scrub: true,
            onUpdate: (self) => {
                gsap.to(scroller, { xPercent: -6 * self.progress, duration: 0.15, overwrite: true });
            },
        });
    });

    onDestroy(() => {
        if (trigger) trigger.kill();
    });
</script>

<section id="achievements" class="section-wrap" bind:this={section}>
    <div class="mx-auto w-full max-w-6xl px-6">
        <SectionTitle number="05" title="Achievements" subtitle="Scholarships, training experiences, and organizations that shape my growth as an engineer." />

        <div class="overflow-x-auto pb-3" style="scroll-snap-type: x mandatory;">
            <div bind:this={scroller} class="flex min-w-max gap-4">
                {#each achievements as item}
                    <article class="w-72 shrink-0 snap-start rounded-2xl border border-[var(--color-primary)]/35 bg-[var(--color-surface)] p-5 transition hover:shadow-[0_0_40px_rgba(99,102,241,0.35)]">
                        <div class="mb-4 h-1 w-full rounded-full bg-[var(--color-warm)]"></div>
                        <item.icon class="mx-auto mb-4 h-7 w-7 text-[var(--color-primary)]" aria-hidden="true" />
                        <h3 class="text-center text-base font-semibold leading-snug">{item.title}</h3>
                    </article>
                {/each}
            </div>
        </div>
    </div>
</section>
