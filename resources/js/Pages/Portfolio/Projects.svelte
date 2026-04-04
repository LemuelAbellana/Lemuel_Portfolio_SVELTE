<script>
    import { projects } from '../../lib/projects';

    const categories = ['All', ...new Set(projects.map((project) => project.category))];
    const imageExtensions = ['webp', 'jpg', 'png'];

    let query = $state('');
    let selectedCategory = $state('All');
    let imageStageByName = $state({});
    let selectedProjectImage = $state(null);

    const getProjectSlug = (projectName) =>
        projectName
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');

    const getProjectImageSrc = (project) => {
        const stage = imageStageByName[project.name] ?? 0;

        if (project.image) {
            return stage === 0 ? `/assets/images/projects/${project.image}` : null;
        }

        if (stage >= imageExtensions.length) return null;
        return `/assets/images/projects/${getProjectSlug(project.name)}.${imageExtensions[stage]}`;
    };

    const handleProjectImageError = (projectName) => {
        const currentStage = imageStageByName[projectName] ?? 0;
        imageStageByName[projectName] = currentStage + 1;
    };

    const openImageModal = (src) => {
        selectedProjectImage = src;
    };

    const closeImageModal = () => {
        selectedProjectImage = null;
    };

    const handleWindowKeydown = (event) => {
        if (event.key === 'Escape' && selectedProjectImage) {
            closeImageModal();
        }
    };

    const openFullImage = (src) => {
        if (!src) return;
        window.open(src, '_blank', 'noopener,noreferrer');
    };

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

<svelte:window onkeydown={handleWindowKeydown} />

<main class="min-h-screen text-[var(--color-text)]">
    <section class="mx-auto w-full max-w-7xl px-4 pb-20 pt-16 md:px-6 md:pt-20">
        <div class="mb-10 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.32em] text-[var(--color-muted)]">Portfolio</p>
                <h1 class="mt-3 text-3xl font-bold text-[var(--color-warm)] md:text-4xl">All Projects</h1>
                <p class="mt-3 max-w-2xl text-sm text-[var(--color-muted)] md:text-base">
                    Browse All Projects by Category or Search by Keywords, Technologies, Roles, and Outcomes
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
                    <article class="group rounded-2xl border border-[var(--color-primary)]/45 bg-[color-mix(in_srgb,var(--color-surface)_92%,black)] p-6 shadow-[0_12px_38px_rgba(0,0,0,0.35)] transition hover:-translate-y-1">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <span class="text-xs font-semibold uppercase tracking-[0.16em] text-[var(--color-warm)]">#{String(i + 1).padStart(2, '0')}</span>
                            <span class="rounded-full border border-[var(--color-border)] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-[var(--color-muted)]">{project.category}</span>
                        </div>

                        <h2 class="min-h-[5rem] text-center text-[clamp(1.25rem,1.5vw,1.85rem)] font-bold leading-tight text-[var(--color-warm)]">{project.name}</h2>
                        <p class="min-h-[4.5rem] text-justify text-[clamp(0.85rem,0.95vw,1.1rem)] leading-snug text-[var(--color-muted)]">{project.description}</p>

                        <div class="mt-2 mb-4 overflow-hidden rounded-xl border border-[var(--color-primary)]/40 bg-[var(--color-bg)]/70 aspect-[4/3]">
                            {#if getProjectImageSrc(project)}
                                <button type="button" class="h-full w-full" onclick={() => openImageModal(getProjectImageSrc(project))} aria-label={`Open full image for ${project.name}`}>
                                    <img
                                        src={getProjectImageSrc(project)}
                                        alt={`${project.name} preview`}
                                        class="h-full w-full cursor-zoom-in object-cover transition-opacity hover:opacity-90"
                                        loading="lazy"
                                        onerror={() => handleProjectImageError(project.name)}
                                    />
                                </button>
                            {:else}
                                <div class="flex h-full w-full items-center justify-center bg-[radial-gradient(circle_at_20%_10%,rgba(85,37,131,0.28),transparent_52%),linear-gradient(180deg,rgba(9,9,18,0.72),rgba(8,8,15,0.92))] px-4 text-center text-sm font-semibold text-[var(--color-muted)]">
                                    Image will be uploaded once the project has been found.
                                </div>
                            {/if}
                        </div>

                        <div class="mt-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--color-muted)]">Role</p>
                            <p class="mt-1 text-sm text-[var(--color-text)]">{project.role}</p>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            {#each project.tags as tag}
                                <span class="rounded-full border border-[var(--color-primary)]/65 bg-[var(--color-primary)]/12 px-2.5 py-1 text-xs font-semibold text-[var(--color-text)]">{tag}</span>
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

    {#if selectedProjectImage}
        <div class="fixed inset-0 z-[90] flex items-center justify-center p-4" role="dialog" aria-modal="true" tabindex="-1">
            <button type="button" class="absolute inset-0 border-0 bg-black/80" aria-label="Close image preview" onclick={closeImageModal}></button>
            <div class="relative max-h-[94vh] w-auto max-w-[95vw] md:max-w-[1200px]">
                <button
                    type="button"
                    class="absolute right-3 top-3 h-8 w-8 rounded-full border border-white/35 bg-black/60 text-xl leading-none text-white"
                    aria-label="Close image preview"
                    onclick={closeImageModal}
                >
                    &times;
                </button>
                <img
                    src={selectedProjectImage}
                    alt="Project preview"
                    class="block max-h-[94vh] max-w-full rounded-xl border border-white/25 object-contain shadow-[0_22px_70px_rgba(0,0,0,0.46)]"
                />
            </div>
        </div>
    {/if}
</main>
