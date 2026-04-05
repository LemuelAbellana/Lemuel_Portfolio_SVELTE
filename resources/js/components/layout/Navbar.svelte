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
            if (window.location.hash) {
                window.history.replaceState({}, '', `${window.location.pathname}${window.location.search}`);
            }
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        isOpen = false;
    };

    const navigateTo = (item) => {
        if (item?.href === '/' && window.location.pathname === '/') {
            if (window.location.hash) {
                window.history.replaceState({}, '', `${window.location.pathname}${window.location.search}`);
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
            isOpen = false;
            return;
        }

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
    <div class="flex w-full items-center justify-between px-3 py-4 md:px-6">
        <a class="inline-flex items-center" href="/" aria-label="Go to Home section">
            <img src="/assets/images/logolems.png" alt="Lems logo" class="brand-logo h-11 w-auto object-contain" />
            <span class="mobile-brand-inline sm:hidden">LEMUEL ABELLANA</span>
            <span class="brand-name hidden sm:inline">LEMUEL ABELLANA</span>
        </a>

        <div class="ml-auto flex items-center gap-3 md:gap-8">
            <div class="hidden items-center gap-8 md:flex">
                {#each navLinks as item}
                    <button type="button" class="text-base font-medium text-[var(--color-text)]/90 transition-colors hover:text-[var(--color-warm)]" onclick={() => navigateTo(item)} aria-label={`Go to ${item.label}`}>
                        {item.label}
                    </button>
                {/each}
            </div>
            <a href="/download-cv" class="hidden rounded-full bg-[var(--color-warm)] px-5 py-2.5 text-sm font-semibold text-[#1a1200] transition hover:brightness-95 md:inline-flex">
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
                <button type="button" class="block w-full rounded-lg px-3 py-2 text-left text-base text-[var(--color-text)] transition-colors hover:bg-[var(--color-primary)]/10 hover:text-[var(--color-warm)]" onclick={() => navigateTo(item)} aria-label={`Go to ${item.label}`}>
                    {item.label}
                </button>
            {/each}
            <a href="/download-cv" class="inline-flex w-full justify-center rounded-lg bg-[var(--color-warm)] px-4 py-2.5 text-base font-semibold text-[#1a1200] transition hover:brightness-95">
                Download CV
            </a>
        </div>
    </div>
</nav>

<style>
    .brand-name {
        margin-left: 0.72rem;
        font-family: var(--font-sans);
        font-style: normal;
        font-size: clamp(1rem, 1.45vw, 1.45rem);
        font-weight: 800;
        line-height: 1;
        letter-spacing: 0.02em;
        color: var(--color-warm);
        text-shadow: 0 0 8px rgba(253, 185, 39, 0.35), 0 0 22px rgba(253, 185, 39, 0.28);
        animation: brandGlow 2.2s ease-in-out infinite alternate;
    }

    .mobile-brand-name {
        padding: 0 0.75rem 0.25rem;
        font-family: var(--font-sans);
        font-style: normal;
        font-size: 1rem;
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: 0.02em;
        color: var(--color-warm);
        text-shadow: 0 0 8px rgba(253, 185, 39, 0.35), 0 0 22px rgba(253, 185, 39, 0.28);
        animation: brandGlow 2.2s ease-in-out infinite alternate;
    }

    .mobile-brand-inline {
        margin-left: 0.55rem;
        font-family: var(--font-sans);
        font-style: normal;
        font-size: clamp(0.84rem, 3.9vw, 1rem);
        font-weight: 800;
        line-height: 1;
        letter-spacing: 0.02em;
        color: var(--color-warm);
        text-shadow: 0 0 8px rgba(253, 185, 39, 0.35), 0 0 22px rgba(253, 185, 39, 0.28);
        animation: brandGlow 2.2s ease-in-out infinite alternate;
        white-space: nowrap;
    }

    @keyframes brandGlow {
        from {
            text-shadow: 0 0 6px rgba(253, 185, 39, 0.28), 0 0 16px rgba(253, 185, 39, 0.18);
        }
        to {
            text-shadow: 0 0 10px rgba(253, 185, 39, 0.45), 0 0 26px rgba(253, 185, 39, 0.33);
        }
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
