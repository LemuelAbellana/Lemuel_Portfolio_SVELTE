<script>
    let { links = [], profile = {} } = $props();
    const navLinks = $derived(links);
    const socials = $derived([
        {
            label: 'GitHub',
            href: profile.github,
            icon: 'github',
        },
        {
            label: 'LinkedIn',
            href: profile.linkedin,
            icon: 'linkedin',
        },
        {
            label: 'X',
            href: profile.twitter,
            icon: 'x',
        },
        {
            label: 'Instagram',
            href: profile.instagram,
            icon: 'instagram',
        },
        {
            label: 'WhatsApp',
            href: profile.whatsapp,
            icon: 'whatsapp',
        },
    ]);

    const tickerTop = 'Thanks for visiting my portfolio! ';
    const tickerBottom = 'Code & Crafted with gold by Lemuel G. Abellana ';

    const scrollToSection = (id) => {
        const el = document.getElementById(id);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    $effect(() => {
        navLinks;
        socials.length;
    });
</script>

<footer class="border-t border-[var(--color-primary)]/30 pt-10">
    <div class="mx-auto w-full max-w-6xl px-6">
        <p class="text-center text-[1.65rem] text-[var(--color-text)]">Connect with me on:</p>
        <div class="mt-5 flex items-center justify-center gap-5">
            {#each socials as social}
                <a
                    href={social.href || '#'}
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label={`Open ${social.label}`}
                    class="rounded-full border border-transparent p-2 text-[var(--color-muted)] transition hover:border-[var(--color-primary)]/40 hover:text-[var(--color-text)]"
                    class:pointer-events-none={!social.href}
                    class:opacity-40={!social.href}
                >
                    <span class="h-6 w-6" aria-hidden="true">
                        {#if social.icon === 'github'}
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-full w-full" role="img" aria-hidden="true">
                                <path d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-1.8c-2.9.6-3.5-1.2-3.5-1.2-.5-1.1-1.1-1.4-1.1-1.4-.9-.6.1-.6.1-.6 1 .1 1.6 1 1.6 1 .9 1.5 2.4 1.1 3 .8.1-.7.4-1.1.6-1.4-2.3-.3-4.7-1.1-4.7-5a3.9 3.9 0 0 1 1-2.7c-.1-.2-.4-1.3.1-2.7 0 0 .9-.3 2.8 1a9.8 9.8 0 0 1 5 0c1.9-1.3 2.8-1 2.8-1 .5 1.4.2 2.5.1 2.7a3.9 3.9 0 0 1 1 2.7c0 3.9-2.4 4.7-4.7 5 .4.3.7 1 .7 2v3c0 .3.2.6.7.5A10 10 0 0 0 12 2z" />
                            </svg>
                        {:else if social.icon === 'linkedin'}
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-full w-full" role="img" aria-hidden="true">
                                <path d="M20.4 20.5h-3.6v-5.6c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9v5.7H9.3V9h3.4v1.6h.1c.5-.9 1.6-1.9 3.3-1.9 3.6 0 4.3 2.4 4.3 5.4v6.4zM5.3 7.4a2.1 2.1 0 1 1 0-4.2 2.1 2.1 0 0 1 0 4.2zM7.1 20.5H3.5V9h3.6v11.5zM22 0H2C.9 0 0 .9 0 2v20c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V2c0-1.1-.9-2-2-2z" />
                            </svg>
                        {:else if social.icon === 'x'}
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-full w-full" role="img" aria-hidden="true">
                                <path d="M18.2 3h2.9l-6.3 7.2L22 21h-5.7l-4.5-5.8L6.7 21H3.8l6.8-7.7L2 3h5.8l4.1 5.4L18.2 3zm-1 16.3h1.6L7 4.6H5.3l11.9 14.7z" />
                            </svg>
                        {:else if social.icon === 'instagram'}
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-full w-full" role="img" aria-hidden="true">
                                <path d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2zm0 1.9A3.9 3.9 0 0 0 3.9 7.8v8.4a3.9 3.9 0 0 0 3.9 3.9h8.4a3.9 3.9 0 0 0 3.9-3.9V7.8a3.9 3.9 0 0 0-3.9-3.9H7.8zm8.8 1.4a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 1.9a3.1 3.1 0 1 0 0 6.2 3.1 3.1 0 0 0 0-6.2z" />
                            </svg>
                        {:else}
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-full w-full" role="img" aria-hidden="true">
                                <path d="M20 4.8A9.8 9.8 0 0 0 4.2 16.3L3 21l4.8-1.2A9.8 9.8 0 1 0 20 4.8zM12 20a7.8 7.8 0 0 1-3.9-1.1l-.3-.2-2.8.7.8-2.7-.2-.3A7.8 7.8 0 1 1 12 20zm4.2-5.8c-.2-.1-1.4-.7-1.6-.7s-.4-.1-.6.1c-.2.2-.7.7-.8.9-.1.1-.3.2-.5.1-.2-.1-.9-.3-1.7-1.1-.6-.5-1.1-1.2-1.2-1.4-.1-.2 0-.3.1-.4l.4-.5.2-.4c.1-.1 0-.3 0-.4l-.6-1.5c-.1-.2-.3-.2-.5-.2h-.4c-.1 0-.4.1-.6.3s-.8.8-.8 2 .8 2.4.9 2.6c.1.2 1.5 2.3 3.7 3.2.5.2 1 .4 1.4.5.6.2 1.2.2 1.7.1.5-.1 1.4-.6 1.6-1.2.2-.6.2-1.1.1-1.2-.1-.1-.3-.1-.5-.2z" />
                            </svg>
                        {/if}
                    </span>
                </a>
            {/each}
        </div>

        <div class="mt-10 overflow-hidden border-y border-[var(--color-primary)]/20 py-4">
            <div class="footer-ticker footer-ticker-left text-[2.35rem] font-semibold leading-none text-[var(--color-muted)]/80">
                <span>{tickerTop}{tickerTop}{tickerTop}{tickerTop}</span>
                <span>{tickerTop}{tickerTop}{tickerTop}{tickerTop}</span>
            </div>
            <div class="footer-ticker footer-ticker-right mt-4 text-[2.2rem] font-semibold leading-none text-[var(--color-muted)]/80">
                <span>{tickerBottom}{tickerBottom}{tickerBottom}{tickerBottom}</span>
                <span>{tickerBottom}{tickerBottom}{tickerBottom}{tickerBottom}</span>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap items-center justify-center gap-3 pb-8 text-sm text-[var(--color-muted)]">
            {#each navLinks as item}
                <button type="button" class="hover:text-[var(--color-text)]" onclick={() => scrollToSection(item.id)} aria-label={`Go to ${item.label} section`}>
                    {item.label}
                </button>
            {/each}
            <span class="w-full text-center text-xs uppercase tracking-[0.16em] text-[var(--color-muted)]/80">© 2026 Lemuel G. Abellana</span>
        </div>
    </div>
</footer>

<style>
    .footer-ticker {
        display: flex;
        gap: 2.5rem;
        white-space: nowrap;
    }

    .footer-ticker span {
        min-width: max-content;
    }

    .footer-ticker-left {
        animation: footer-marquee-left 28s linear infinite;
    }

    .footer-ticker-right {
        animation: footer-marquee-right 32s linear infinite;
    }

    @keyframes footer-marquee-left {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(-50%);
        }
    }

    @keyframes footer-marquee-right {
        from {
            transform: translateX(-50%);
        }
        to {
            transform: translateX(0);
        }
    }

    @media (max-width: 767px) {
        .footer-ticker-left,
        .footer-ticker-right {
            font-size: 1.38rem;
        }
    }
</style>
