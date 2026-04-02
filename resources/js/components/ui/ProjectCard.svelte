<script>
    import { onMount } from 'svelte';
    import { ArrowUpRight } from 'lucide-svelte';
    import { gsap } from '../../lib/gsap';

    let { index = 1, name = '', description = '', tags = [], role = '', features = [], outcome = '' } = $props();

    let card = $state(null);
    const cardTitle = $derived(name);

    const onMove = (event) => {
        if (!card) return;
        const rect = card.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        const rotateY = ((x / rect.width) - 0.5) * 16;
        const rotateX = ((y / rect.height) - 0.5) * -16;

        gsap.to(card, {
            rotateX,
            rotateY,
            transformPerspective: 900,
            transformOrigin: 'center',
            duration: 0.25,
            ease: 'power2.out',
        });
    };

    const onLeave = () => {
        if (!card) return;
        gsap.to(card, { rotateX: 0, rotateY: 0, duration: 0.45, ease: 'power3.out' });
    };

    $effect(() => {
        cardTitle;
    });

    onMount(() => {
        return () => {
            if (card) gsap.killTweensOf(card);
        };
    });
</script>

<article
    bind:this={card}
    onmousemove={onMove}
    onmouseleave={onLeave}
    role="region"
    aria-label={`Project ${index}: ${cardTitle}`}
    class="project-card relative rounded-2xl border border-[var(--color-primary)]/40 bg-[var(--color-surface)] p-6 shadow-[inset_0_0_24px_rgba(99,102,241,0.08)]"
>
    <span class="font-display absolute right-4 top-2 text-7xl text-white/5">{String(index).padStart(2, '0')}</span>
    <ArrowUpRight class="absolute right-4 top-4 h-5 w-5 text-[var(--color-muted)]" aria-hidden="true" />
    <h3 class="relative mb-3 text-lg font-semibold text-[var(--color-text)]">{cardTitle}</h3>
    <p class="relative mb-4 text-sm text-[var(--color-muted)]">{description}</p>
    <p class="relative mb-4 text-xs uppercase tracking-wider text-[var(--color-warm)]">Role: {role}</p>

    <div class="relative mb-4">
        <p class="mb-2 text-xs uppercase tracking-wider text-[var(--color-muted)]">Key Features</p>
        <ul class="space-y-1 text-sm text-[var(--color-text)]/90">
            {#each features as feature}
                <li>• {feature}</li>
            {/each}
        </ul>
    </div>

    <p class="relative mb-4 text-sm text-[var(--color-muted)]"><span class="text-[var(--color-text)]">Outcome:</span> {outcome}</p>
    <div class="relative flex flex-wrap gap-2">
        {#each tags as tag}
            <span class="rounded-full border border-[var(--color-primary)]/35 px-2.5 py-1 text-xs font-mono text-[var(--color-text)]">
                {tag}
            </span>
        {/each}
    </div>
</article>
