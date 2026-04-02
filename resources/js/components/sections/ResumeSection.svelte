<script>
    import SectionTitle from '../ui/SectionTitle.svelte';

    let { profile } = $props();
    const fullName = $derived(profile.name ?? 'Resume');
</script>

<section id="resume" class="section-wrap pt-0">
    <div class="mx-auto w-full max-w-6xl px-6">
        <div class="rounded-3xl border border-[var(--color-primary)]/35 bg-[color-mix(in_srgb,var(--color-surface)_88%,black)] p-8 md:p-10">
            <SectionTitle
                number="07"
                title="Resume"
                subtitle="Download a complete summary of technical skills, projects, and leadership experience."
            />

            <div class="flex flex-col items-start justify-between gap-5 border-t border-[var(--color-primary)]/20 pt-6 md:flex-row md:items-center">
                <p class="max-w-2xl text-[var(--color-muted)]">
                    The PDF resume includes verified academic credentials, development experience, and organizational leadership roles of
                    {fullName}.
                </p>
                <a
                    href="/download-cv"
                    class="inline-flex items-center justify-center rounded-full bg-[var(--color-primary)] px-7 py-3 text-sm font-semibold text-white transition hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:ring-offset-2 focus:ring-offset-[var(--color-bg)]"
                >
                    Download Resume
                </a>
            </div>
        </div>
    </div>
</section>
