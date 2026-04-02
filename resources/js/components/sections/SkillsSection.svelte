<script>
    import { onDestroy, onMount } from 'svelte';
    import SectionTitle from '../ui/SectionTitle.svelte';
    import SkillBadge from '../ui/SkillBadge.svelte';
    import { gsap, revealOnScroll } from '../../lib/gsap';

    let section = $state(null);
    let cards = $state([]);
    let trigger = $state(null);

    const groups = [
        {
            label: 'Core',
            title: 'Programming Languages',
            span: 'md:col-span-2',
            items: ['HTML', 'CSS', 'JavaScript', 'Java', 'PHP'],
        },
        {
            label: 'Framework Layer',
            title: 'Frameworks',
            span: '',
            items: ['Laravel (Livewire)', 'React (JS/TS)', 'Express.js', 'Node.js'],
        },
        {
            label: 'Persistence',
            title: 'Databases',
            span: '',
            items: ['MySQL', 'MongoDB'],
        },
        {
            label: 'Architecture',
            title: 'Development Stacks',
            span: '',
            items: ['MERN', 'LAMP'],
        },
        {
            label: 'Specialization',
            title: 'Other Technical Skills',
            span: 'md:col-span-2',
            items: [
                'Server Administration',
                'Web Application Development',
                'Mobile Application Development',
                'Progressive Web Applications (PWA)',
                'AI System Integration',
                'Project Management',
                'Organizational Leadership',
            ],
        },
    ];

    const liftCard = (card) => {
        gsap.to(card, { y: -4, boxShadow: '0 20px 40px rgba(15, 23, 42, 0.45)', duration: 0.2 });
    };

    const resetCard = (card) => {
        gsap.to(card, { y: 0, boxShadow: '0 0 0 rgba(0,0,0,0)', duration: 0.2 });
    };

    $effect(() => {
        groups.length;
    });

    onMount(() => {
        if (!section) return;
        trigger = revealOnScroll(section, cards, { animation: { stagger: 0.16 } });
    });

    onDestroy(() => {
        if (trigger) trigger.kill();
    });
</script>

<section id="skills" class="section-wrap" bind:this={section}>
    <div class="mx-auto w-full max-w-6xl px-6">
        <SectionTitle number="02" title="Skills" subtitle="A practical full-stack skillset shaped by projects, leadership work, and continuous technical training." />

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            {#each groups as group, i}
                <article
                    bind:this={cards[i]}
                    class={`rounded-2xl border border-[var(--color-primary)]/35 bg-[var(--color-surface)] p-6 shadow-[inset_0_0_18px_rgba(99,102,241,0.08)] ${group.span}`}
                    onmouseenter={(e) => liftCard(e.currentTarget)}
                    onmouseleave={(e) => resetCard(e.currentTarget)}
                >
                    <p class="mb-2 text-xs uppercase tracking-widest text-[var(--color-muted)]">{group.label}</p>
                    <h3 class="mb-4 text-lg font-semibold">{group.title}</h3>
                    <div class="flex flex-wrap gap-2.5">
                        {#each group.items as item}
                            <SkillBadge label={item} />
                        {/each}
                    </div>
                </article>
            {/each}
        </div>
    </div>
</section>
