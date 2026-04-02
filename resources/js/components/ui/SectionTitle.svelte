<script>
    import { onMount } from 'svelte';

    let { number = '00', title = '', subtitle = '' } = $props();
    const localNumber = $derived(number);
    let root = $state(null);

    $effect(() => {
        localNumber;
    });

    onMount(() => {
        return () => {};
    });
</script>

<div class="relative mb-12" bind:this={root}>
    <span class="font-display absolute -top-10 left-0 text-8xl text-white/5">{localNumber}</span>
    <h2 class="font-display relative text-4xl md:text-5xl text-[var(--color-text)]">{title}</h2>
    {#if subtitle}
        <p class="mt-4 max-w-2xl text-[var(--color-muted)]">{subtitle}</p>
    {/if}
</div>
