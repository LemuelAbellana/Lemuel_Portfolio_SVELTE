<script>
    import { onMount } from 'svelte';

    let { number = '00', title = '', subtitle = '', useSans = false, showNumber = true } = $props();
    const localNumber = $derived(number);
    let root = $state(null);

    $effect(() => {
        localNumber;
    });

    onMount(() => {
        return () => {};
    });
</script>

<div class="relative mb-12 text-center" bind:this={root}>
    {#if showNumber}
        <span class="font-display absolute -top-10 left-1/2 -translate-x-1/2 text-8xl text-white/5">{localNumber}</span>
    {/if}
    <h2 class={`relative text-4xl md:text-5xl text-[var(--color-text)] ${useSans ? 'font-sans font-bold tracking-[-0.02em]' : 'font-display'}`}>{title}</h2>
    {#if subtitle}
        <p class={`mt-4 mx-auto max-w-2xl text-[var(--color-muted)] ${useSans ? 'font-sans' : ''}`}>{subtitle}</p>
    {/if}
</div>
