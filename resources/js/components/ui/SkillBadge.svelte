<script>
    import { onMount } from 'svelte';

    let { label = '' } = $props();
    const value = $derived(label);
    let badge = $state(null);

    $effect(() => {
        value;
    });

    onMount(() => {
        return () => {};
    });
</script>

<span
    bind:this={badge}
    class="inline-flex items-center gap-2 rounded-full border border-[var(--color-primary)]/50 bg-[color-mix(in_srgb,var(--color-primary)_10%,transparent)] px-3 py-1.5 text-xs md:text-sm font-mono text-[var(--color-text)]"
>
    <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-warm)]"></span>
    {value}
</span>
