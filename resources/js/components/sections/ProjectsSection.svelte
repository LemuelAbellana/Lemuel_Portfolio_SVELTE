<script>
    import { onDestroy, onMount } from 'svelte';
    import SectionTitle from '../ui/SectionTitle.svelte';
    import ProjectCard from '../ui/ProjectCard.svelte';
    import { revealOnScroll } from '../../lib/gsap';
    import { projects } from '../../lib/projects';

    let section = $state(null);
    let cardNodes = $state([]);
    let trigger = $state(null);

    const featuredProjects = $derived(projects.filter((project) => project.featured).slice(0, 3));

    $effect(() => {
        featuredProjects.length;
    });

    onMount(() => {
        if (!section) return;
        trigger = revealOnScroll(section, cardNodes, { animation: { stagger: 0.14 } });
    });

    onDestroy(() => {
        if (trigger) trigger.kill();
    });
</script>

<section id="projects" class="section-wrap" bind:this={section}>
    <div class="mx-auto w-full max-w-6xl px-6">
        <SectionTitle number="03" title="Featured Projects" subtitle="A focused selection of three projects. Visit the projects page to explore the full portfolio." />

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            {#each featuredProjects as project, i}
                <div bind:this={cardNodes[i]}>
                    <ProjectCard
                        index={i + 1}
                        name={project.name}
                        description={project.description}
                        tags={project.tags}
                        role={project.role}
                        features={project.features}
                        outcome={project.outcome}
                    />
                </div>
            {/each}
        </div>

        <div class="mt-10 flex justify-center">
            <a href="/projects" class="rounded-full bg-[var(--color-warm)] px-7 py-3 text-sm font-semibold text-[var(--color-bg)] transition hover:brightness-110">
                View All Projects
            </a>
        </div>
    </div>
</section>
