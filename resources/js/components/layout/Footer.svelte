<script>
    import { onMount } from 'svelte';

    let { links = [] } = $props();
    const navLinks = $derived(links);
    let mounted = $state(false);

    const scrollToSection = (id) => {
        const el = document.getElementById(id);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    $effect(() => {
        navLinks;
    });

    onMount(() => {
        mounted = true;
    });
</script>

<footer class="border-t border-[var(--color-primary)]/30 py-8">
    <div class="mx-auto flex w-full max-w-6xl flex-col items-center justify-between gap-4 px-6 text-sm md:flex-row">
        <span class="font-display text-xl italic text-[var(--color-primary)]">&lt;LA/&gt;</span>
        <div class="flex items-center gap-5">
            {#each navLinks as item}
                <button type="button" class="text-[var(--color-muted)] hover:text-[var(--color-text)]" onclick={() => scrollToSection(item.id)} aria-label={`Go to ${item.label} section`}>
                    {item.label}
                </button>
            {/each}
        </div>
        <span class="text-[var(--color-muted)]">© 2026 Lemuel G. Abellana. Built with Laravel & Svelte.</span>
    </div>
</footer>
