<script>
    import { onDestroy, onMount } from 'svelte';
    import SectionTitle from '../ui/SectionTitle.svelte';
    import ProjectCard from '../ui/ProjectCard.svelte';
    import { revealOnScroll } from '../../lib/gsap';

    let section = $state(null);
    let cardNodes = $state([]);
    let trigger = $state(null);

    const projects = [
        {
            name: 'IP Management System',
            description: 'A Progressive Web Application that streamlines the intellectual property protection application process.',
            tags: ['PWA', 'Laravel', 'PHP'],
            role: 'Full-Stack Developer',
            features: ['Application tracking workflow', 'Role-based dashboard', 'Document upload and validation'],
            outcome: 'Improved process visibility and reduced manual submission bottlenecks.',
        },
        {
            name: 'RPIC Research Management',
            description: 'A scheduling and document management platform for research paper defenses and academic seminars.',
            tags: ['Laravel', 'MySQL'],
            role: 'Backend and Database Developer',
            features: ['Defense scheduling module', 'Panel assignment workflow', 'Research document repository'],
            outcome: 'Helped coordinators manage defense timelines with better organization.',
        },
        {
            name: 'Anime Dojo Game',
            description: 'An AI-powered interactive game that predicts outcomes and generates personalized user insights.',
            tags: ['AI', 'JavaScript', 'Node.js'],
            role: 'Game Systems Developer',
            features: ['AI-assisted prediction engine', 'Session-based scoring', 'Interactive gameplay loops'],
            outcome: 'Delivered a more engaging and personalized player experience.',
        },
        {
            name: 'Clinic-Connect',
            description: 'A platform for managing patient bookings, consultations, and medication purchasing.',
            tags: ['PHP', 'MySQL', 'Web'],
            role: 'Full-Stack Developer',
            features: ['Appointment booking system', 'Consultation queue management', 'Medication catalog and ordering'],
            outcome: 'Centralized clinic workflows into one web platform for staff and patients.',
        },
        {
            name: 'NASA Weather App',
            description: 'A mobile app using AI and NASA data to deliver weather safety insights for communities.',
            tags: ['AI', 'NASA API', 'Mobile'],
            role: 'Mobile and API Integrator',
            features: ['NASA weather data integration', 'Risk insight summaries', 'Location-based weather alerts'],
            outcome: 'Provided clearer weather safety guidance for local users.',
        },
        {
            name: 'House Rental System',
            description: 'A web application for managing rental listings and tracking tenants.',
            tags: ['Laravel', 'MySQL', 'Web'],
            role: 'Full-Stack Developer',
            features: ['Listing and tenant management', 'Rental status dashboard', 'Record maintenance module'],
            outcome: 'Simplified rental operations and reduced manual property tracking tasks.',
        },
    ];

    $effect(() => {
        projects.length;
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
        <SectionTitle number="03" title="Projects" subtitle="Six applied systems spanning web, mobile, AI integration, and research process management." />

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            {#each projects as project, i}
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
    </div>
</section>
