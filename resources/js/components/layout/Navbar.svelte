<script>
    import { onMount } from 'svelte';
    import { Menu, X } from 'lucide-svelte';
    import { gsap } from '../../lib/gsap';

    let { links = [] } = $props();
    const navLinks = $derived(links);
    let isOpen = $state(false);
    let mobileMenu = $state(null);

    const scrollToSection = (id) => {
        const el = document.getElementById(id);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        isOpen = false;
    };

    const toggleMenu = () => {
        isOpen = !isOpen;
    };

    $effect(() => {
        if (!mobileMenu) return;
        gsap.killTweensOf(mobileMenu);
        if (isOpen) {
            gsap.fromTo(mobileMenu, { height: 0, opacity: 0 }, { height: 'auto', opacity: 1, duration: 0.35, ease: 'power3.out' });
        } else {
            gsap.to(mobileMenu, { height: 0, opacity: 0, duration: 0.25, ease: 'power3.out' });
        }
    });

    onMount(() => {
        return () => {
            if (mobileMenu) {
                gsap.killTweensOf(mobileMenu);
            }
        };
    });
</script>

<nav
    class="fixed left-0 top-0 z-50 w-full border-b border-[var(--color-warm)]/25 backdrop-blur-md"
    style="background: linear-gradient(180deg, rgba(11, 10, 18, 0.96) 0%, rgba(17, 13, 30, 0.92) 100%);"
    aria-label="Main navigation"
>
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
        <button type="button" class="inline-flex items-center" onclick={() => scrollToSection('home')} aria-label="Go to Home section">
            <img src="/assets/images/logolems.png" alt="Lems logo" class="h-11 w-auto object-contain" />
        </button>

        <div class="hidden items-center gap-8 md:flex">
            {#each navLinks as item}
                <button type="button" class="text-sm font-medium text-[var(--color-text)]/90 hover:text-[var(--color-primary)]" onclick={() => scrollToSection(item.id)} aria-label={`Go to ${item.label} section`}>
                    {item.label}
                </button>
            {/each}
        </div>

        <div class="flex items-center gap-3">
            <a href="/resume.pdf" download class="hidden rounded-full border border-[var(--color-primary)] px-4 py-2 text-xs font-medium text-[var(--color-text)] transition hover:bg-[var(--color-primary)]/20 md:inline-flex">
                Download CV
            </a>
            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[var(--color-primary)]/50 text-[var(--color-text)] md:hidden" onclick={toggleMenu} aria-label="Toggle mobile navigation" aria-expanded={isOpen} aria-controls="mobile-menu">
                {#if isOpen}
                    <X class="h-5 w-5" />
                {:else}
                    <Menu class="h-5 w-5" />
                {/if}
            </button>
        </div>
    </div>

    <div id="mobile-menu" bind:this={mobileMenu} class="overflow-hidden md:hidden" style="height: 0; opacity: 0;">
        <div class="space-y-2 border-t border-[var(--color-primary)]/20 px-6 py-4">
            {#each navLinks as item}
                <button type="button" class="block w-full rounded-lg px-3 py-2 text-left text-sm text-[var(--color-text)] hover:bg-[var(--color-primary)]/10" onclick={() => scrollToSection(item.id)} aria-label={`Go to ${item.label} section`}>
                    {item.label}
                </button>
            {/each}
            <a href="/resume.pdf" download class="inline-flex w-full justify-center rounded-lg border border-[var(--color-primary)] px-4 py-2 text-sm text-[var(--color-text)]">
                Download CV
            </a>
        </div>
    </div>
</nav>
