<script>
    import { onDestroy, onMount } from 'svelte';
    import SectionTitle from '../ui/SectionTitle.svelte';
    import { revealOnScroll } from '../../lib/gsap';

    let { profile } = $props();

    let section = $state(null);
    let trigger = $state(null);

    const socials = $derived([
        {
            key: 'facebook',
            name: 'Facebook',
            href: profile.facebook,
        },
        {
            key: 'instagram',
            name: 'Instagram',
            href: profile.instagram,
        },
        {
            key: 'github',
            name: 'GitHub',
            href: profile.github,
        },
        {
            key: 'linkedin',
            name: 'LinkedIn',
            href: profile.linkedin,
        },
    ]);

    onMount(() => {
        if (!section) return;
        trigger = revealOnScroll(section, section.querySelectorAll('[data-contact-item]'));
    });

    onDestroy(() => {
        if (trigger) trigger.kill();
    });
</script>

<section id="contact" class="section-wrap" bind:this={section}>
    <div class="mx-auto w-full max-w-6xl px-6">
        <SectionTitle number="06" title="Connect" subtitle="Find me on social platforms and connect directly." />

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-contact-item>
            {#each socials as social}
                <a
                    href={social.href}
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label={`Open ${social.name} profile`}
                    class="group flex min-h-[150px] flex-col items-center justify-center rounded-2xl border border-[var(--color-primary)]/35 bg-[var(--color-surface)] p-6 text-center transition hover:border-[var(--color-warm)] hover:-translate-y-1"
                >
                    <div class="h-8 w-8 text-[var(--color-warm)]" aria-hidden="true">
                        {#if social.key === 'facebook'}
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-full w-full" role="img" aria-hidden="true">
                                <path d="M13.5 22v-8h2.7l.4-3h-3.1V9.1c0-.9.2-1.6 1.5-1.6H17V4.8c-.4-.1-1.4-.2-2.6-.2-2.6 0-4.3 1.6-4.3 4.5V11H7.5v3h2.6v8h3.4z" />
                            </svg>
                        {:else if social.key === 'instagram'}
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-full w-full" role="img" aria-hidden="true">
                                <path d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2zm0 1.9A3.9 3.9 0 0 0 3.9 7.8v8.4a3.9 3.9 0 0 0 3.9 3.9h8.4a3.9 3.9 0 0 0 3.9-3.9V7.8a3.9 3.9 0 0 0-3.9-3.9H7.8zm8.8 1.4a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 1.9a3.1 3.1 0 1 0 0 6.2 3.1 3.1 0 0 0 0-6.2z" />
                            </svg>
                        {:else if social.key === 'github'}
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-full w-full" role="img" aria-hidden="true">
                                <path d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-1.8c-2.9.6-3.5-1.2-3.5-1.2-.5-1.1-1.1-1.4-1.1-1.4-.9-.6.1-.6.1-.6 1 .1 1.6 1 1.6 1 .9 1.5 2.4 1.1 3 .8.1-.7.4-1.1.6-1.4-2.3-.3-4.7-1.1-4.7-5a3.9 3.9 0 0 1 1-2.7c-.1-.2-.4-1.3.1-2.7 0 0 .9-.3 2.8 1a9.8 9.8 0 0 1 5 0c1.9-1.3 2.8-1 2.8-1 .5 1.4.2 2.5.1 2.7a3.9 3.9 0 0 1 1 2.7c0 3.9-2.4 4.7-4.7 5 .4.3.7 1 .7 2v3c0 .3.2.6.7.5A10 10 0 0 0 12 2z" />
                            </svg>
                        {:else}
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-full w-full" role="img" aria-hidden="true">
                                <path d="M20.4 20.5h-3.6v-5.6c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9v5.7H9.3V9h3.4v1.6h.1c.5-.9 1.6-1.9 3.3-1.9 3.6 0 4.3 2.4 4.3 5.4v6.4zM5.3 7.4a2.1 2.1 0 1 1 0-4.2 2.1 2.1 0 0 1 0 4.2zM7.1 20.5H3.5V9h3.6v11.5zM22 0H2C.9 0 0 .9 0 2v20c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V2c0-1.1-.9-2-2-2z" />
                            </svg>
                        {/if}
                    </div>
                    <p class="mt-4 text-lg font-semibold text-[var(--color-text)]">{social.name}</p>
                    <p class="mt-1 text-xs uppercase tracking-[0.12em] text-[var(--color-muted)]">Visit Profile</p>
                </a>
            {/each}
        </div>
    </div>
</section>
