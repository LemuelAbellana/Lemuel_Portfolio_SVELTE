<script>
    import { onMount } from 'svelte';
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

    const navigateTo = (item) => {
        if (item?.href) {
            window.location.href = item.href;
            isOpen = false;
            return;
        }

        if (item?.id) {
            scrollToSection(item.id);
        }
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
        <a class="inline-flex items-center" href="/" aria-label="Go to Home section">
            <img src="/assets/images/logolems.png" alt="Lems logo" class="brand-logo h-11 w-auto object-contain" />
            <span class="mobile-brand-inline sm:hidden">LEMUEL ABELLANA</span>
            <span class="brand-name hidden sm:inline">LEMUEL ABELLANA</span>
        </a>

        <div class="hidden items-center gap-8 md:flex">
            {#each navLinks as item}
                <button type="button" class="text-sm font-medium text-[var(--color-text)]/90 transition-colors hover:text-[var(--color-warm)]" onclick={() => navigateTo(item)} aria-label={`Go to ${item.label}`}>
                    {item.label}
                </button>
            {/each}
        </div>

        <div class="flex items-center gap-3">
            <a href="/resume.pdf" download class="hidden rounded-full border border-[var(--color-primary)] px-4 py-2 text-xs font-medium text-[var(--color-text)] transition hover:bg-[var(--color-primary)]/20 md:inline-flex">
                Download CV
            </a>
            <button type="button" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-[var(--color-primary)]/50 text-[var(--color-warm)] md:hidden" onclick={toggleMenu} aria-label="Toggle mobile navigation" aria-expanded={isOpen} aria-controls="mobile-menu">
                {#if isOpen}
                    <svg class="block" style="width: 1.2rem; height: 1.2rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 6L6 18"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                {:else}
                    <svg class="block" style="width: 1.2rem; height: 1.2rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 7h16"></path>
                        <path d="M4 12h16"></path>
                        <path d="M4 17h16"></path>
                    </svg>
                {/if}
            </button>
        </div>
    </div>

    <div id="mobile-menu" bind:this={mobileMenu} class="overflow-hidden md:hidden" style="height: 0; opacity: 0;">
        <div class="space-y-2 border-t border-[var(--color-primary)]/20 px-6 py-4">
            <div class="mobile-brand-name">LEMUEL ABELLANA</div>
            {#each navLinks as item}
                <button type="button" class="block w-full rounded-lg px-3 py-2 text-left text-sm text-[var(--color-text)] transition-colors hover:bg-[var(--color-primary)]/10 hover:text-[var(--color-warm)]" onclick={() => navigateTo(item)} aria-label={`Go to ${item.label}`}>
                    {item.label}
                </button>
            {/each}
            <a href="/resume.pdf" download class="inline-flex w-full justify-center rounded-lg border border-[var(--color-primary)] px-4 py-2 text-sm text-[var(--color-text)]">
                Download CV
            </a>
        </div>
    </div>
</nav>

<style>
    .brand-name {
        margin-left: 0.72rem;
        font-family: 'Playfair Display', serif;
        font-style: italic;
        font-size: clamp(1rem, 1.45vw, 1.45rem);
        font-weight: 700;
        line-height: 1;
        letter-spacing: 0.02em;
        color: var(--color-warm);
        text-shadow: 0 0 18px rgba(253, 185, 39, 0.22);
    }

    .mobile-brand-name {
        padding: 0 0.75rem 0.25rem;
        font-family: 'Playfair Display', serif;
        font-style: italic;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: 0.02em;
        color: var(--color-warm);
        text-shadow: 0 0 18px rgba(253, 185, 39, 0.22);
    }

    .mobile-brand-inline {
        margin-left: 0.55rem;
        font-family: 'Playfair Display', serif;
        font-style: italic;
        font-size: clamp(0.84rem, 3.9vw, 1rem);
        font-weight: 700;
        line-height: 1;
        letter-spacing: 0.02em;
        color: var(--color-warm);
        text-shadow: 0 0 18px rgba(253, 185, 39, 0.22);
        white-space: nowrap;
    }

    @media (max-width: 420px) {
        nav > div {
            padding-left: 0.9rem;
            padding-right: 0.9rem;
        }

        .brand-logo {
            height: 2.1rem;
        }

        .mobile-brand-inline {
            margin-left: 0.45rem;
            letter-spacing: 0.015em;
        }
    }
</style>
