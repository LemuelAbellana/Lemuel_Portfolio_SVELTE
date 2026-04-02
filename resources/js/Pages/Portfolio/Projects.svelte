<script>
    import { projects } from '../../lib/projects';

    const categories = ['All', ...new Set(projects.map((project) => project.category))];

    let query = $state('');
    let selectedCategory = $state('All');

    const filteredProjects = $derived(
        projects.filter((project) => {
            const matchesCategory = selectedCategory === 'All' || project.category === selectedCategory;
            const searchTarget = [
                project.name,
                project.description,
                project.role,
                project.category,
                ...(project.tags ?? []),
                ...(project.features ?? []),
            ]
                .join(' ')
                .toLowerCase();
            const matchesQuery = searchTarget.includes(query.trim().toLowerCase());

            return matchesCategory && matchesQuery;
        }),
    );
</script>

<svelte:head>
    <title>All Projects | Lemuel Opeña</title>
</svelte:head>

<main class="min-h-screen bg-[var(--color-bg)] text-[var(--color-text)]">
    <section class="mx-auto w-full max-w-6xl px-6 pb-20 pt-16 md:pt-20">
        <div class="mb-10 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.32em] text-[var(--color-muted)]">Portfolio</p>
                <h1 class="mt-3 text-3xl font-bold text-[var(--color-warm)] md:text-4xl">All Projects</h1>
                <p class="mt-3 max-w-2xl text-sm text-[var(--color-muted)] md:text-base">
                    Browse all projects by category or search by keywords, technologies, roles, and outcomes.
                </p>
            </div>
            <a href="/" class="rounded-full border border-[var(--color-border)] px-5 py-2 text-sm font-semibold text-[var(--color-text)] transition hover:border-[var(--color-warm)] hover:text-[var(--color-warm)]">
                Back to Home
            </a>
        </div>

        <div class="mb-8 grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <label class="block">
                <span class="sr-only">Search projects</span>
                <input
                    type="text"
                    bind:value={query}
                    placeholder="Search projects, tags, roles, or features..."
                    class="w-full rounded-xl border border-[var(--color-border)] bg-white/5 px-4 py-3 text-sm text-[var(--color-text)] placeholder:text-[var(--color-muted)] focus:border-[var(--color-warm)] focus:outline-none"
                />
            </label>

            <div class="flex flex-wrap gap-2">
                {#each categories as category}
                    <button
                        type="button"
                        onclick={() => (selectedCategory = category)}
                        class={`rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em] transition ${
                            selectedCategory === category
                                ? 'bg-[var(--color-warm)] text-[var(--color-bg)]'
                                : 'border border-[var(--color-border)] text-[var(--color-muted)] hover:border-[var(--color-warm)] hover:text-[var(--color-warm)]'
                        }`}
                    >
                        {category}
                    </button>
                {/each}
            </div>
        </div>

        {#if filteredProjects.length === 0}
            <div class="rounded-2xl border border-[var(--color-border)] bg-white/5 p-8 text-center">
                <p class="text-base font-semibold text-[var(--color-warm)]">No projects found.</p>
                <p class="mt-2 text-sm text-[var(--color-muted)]">Try changing the category or search terms.</p>
            </div>
        {:else}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                {#each filteredProjects as project, i}
                    <article class="group rounded-2xl border border-[var(--color-border)] bg-white/[0.04] p-5 shadow-[0_16px_40px_rgba(0,0,0,0.18)] transition hover:-translate-y-1 hover:border-[var(--color-warm)]">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <span class="text-xs font-semibold uppercase tracking-[0.16em] text-[var(--color-warm)]">#{String(i + 1).padStart(2, '0')}</span>
                            <span class="rounded-full border border-[var(--color-border)] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-[var(--color-muted)]">{project.category}</span>
                        </div>

                        <h2 class="text-lg font-semibold text-[var(--color-text)]">{project.name}</h2>
                        <p class="mt-3 text-sm leading-relaxed text-[var(--color-muted)]">{project.description}</p>

                        <div class="mt-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--color-muted)]">Role</p>
                            <p class="mt-1 text-sm text-[var(--color-text)]">{project.role}</p>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            {#each project.tags as tag}
                                <span class="rounded-full border border-[var(--color-border)] px-3 py-1 text-xs text-[var(--color-muted)]">{tag}</span>
                            {/each}
                        </div>

                        <div class="mt-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--color-muted)]">Key Features</p>
                            <ul class="mt-2 space-y-1 text-sm text-[var(--color-muted)]">
                                {#each project.features as feature}
                                    <li>• {feature}</li>
                                {/each}
                            </ul>
                        </div>

                        <p class="mt-4 text-sm font-medium text-[var(--color-warm)]">{project.outcome}</p>
                    </article>
                {/each}
            </div>
        {/if}
    </section>
</main>
