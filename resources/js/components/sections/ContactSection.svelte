<script>
    import { onDestroy, onMount } from 'svelte';
    import { Code, Link2, Mail, MapPin, Phone } from 'lucide-svelte';
    import { useForm } from '@inertiajs/svelte';
    import SectionTitle from '../ui/SectionTitle.svelte';
    import { revealOnScroll } from '../../lib/gsap';

    let { profile, flash = {}, errors = {} } = $props();
    const form = useForm({ name: '', email: '', message: '' });

    let section = $state(null);
    let trigger = $state(null);
    const successText = $derived(flash.success ?? '');

    const submit = () => {
        form.post('/contact', {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('message');
            },
        });
    };

    $effect(() => {
        successText;
    });

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
        <SectionTitle number="06" title="Contact" subtitle="Let’s build something reliable and meaningful together." />

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-5" data-contact-item>
                <a href={`mailto:${profile.email}`} class="flex items-center gap-3 text-lg text-[var(--color-text)] hover:text-[var(--color-primary)]">
                    <Mail class="h-5 w-5" aria-hidden="true" />
                    {profile.email}
                </a>
                <p class="flex items-center gap-3 text-[var(--color-muted)]">
                    <Phone class="h-5 w-5 text-[var(--color-primary)]" aria-hidden="true" />
                    {profile.phone}
                </p>
                <p class="flex items-center gap-3 text-[var(--color-muted)]">
                    <MapPin class="h-5 w-5 text-[var(--color-primary)]" aria-hidden="true" />
                    {profile.location}
                </p>

                <div class="flex items-center gap-4 pt-3">
                    <a href="/resume.pdf" download class="rounded-full bg-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-white">Download Resume</a>
                    <a
                        href={profile.linkedin}
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="LinkedIn profile"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[var(--color-primary)]/40 hover:bg-[var(--color-primary)]/10"
                    >
                        <Link2 class="h-5 w-5" aria-hidden="true" />
                    </a>
                    <a
                        href={profile.github}
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="GitHub profile"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[var(--color-primary)]/40 hover:bg-[var(--color-primary)]/10"
                    >
                        <Code class="h-5 w-5" aria-hidden="true" />
                    </a>
                </div>
            </div>

            <form class="rounded-2xl border border-[var(--color-primary)]/35 bg-[var(--color-surface)] p-6" onsubmit={(e) => { e.preventDefault(); submit(); }} data-contact-item>
                {#if successText}
                    <div class="mb-4 rounded-lg border border-emerald-400/30 bg-emerald-400/10 px-3 py-2 text-sm text-emerald-300">{successText}</div>
                {/if}

                <div class="space-y-4">
                    <div>
                        <label for="contact-name" class="mb-1 block text-sm text-[var(--color-muted)]">Full Name</label>
                        <input id="contact-name" type="text" class="w-full rounded-xl border border-[var(--color-primary)]/35 bg-transparent px-3 py-2 outline-none focus:border-[var(--color-primary)]" bind:value={form.name} />
                        {#if errors.name}<p class="mt-1 text-xs text-rose-400">{errors.name}</p>{/if}
                    </div>

                    <div>
                        <label for="contact-email" class="mb-1 block text-sm text-[var(--color-muted)]">Email Address</label>
                        <input id="contact-email" type="email" class="w-full rounded-xl border border-[var(--color-primary)]/35 bg-transparent px-3 py-2 outline-none focus:border-[var(--color-primary)]" bind:value={form.email} />
                        {#if errors.email}<p class="mt-1 text-xs text-rose-400">{errors.email}</p>{/if}
                    </div>

                    <div>
                        <label for="contact-message" class="mb-1 block text-sm text-[var(--color-muted)]">Message</label>
                        <textarea id="contact-message" rows="5" class="w-full rounded-xl border border-[var(--color-primary)]/35 bg-transparent px-3 py-2 outline-none focus:border-[var(--color-primary)]" bind:value={form.message}></textarea>
                        {#if errors.message}<p class="mt-1 text-xs text-rose-400">{errors.message}</p>{/if}
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-white disabled:opacity-60" disabled={form.processing}>
                        {form.processing ? 'Sending...' : 'Send Message'}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
