<script setup lang="ts">

import Authorization from '~/components/Authorization.vue';

</script>

<template>
<main class="auth-page">

    <Authorization/>

</main>
</template>

<style lang="scss">

.auth-page {
    min-width: 100vw;
    min-height: 100vh;
    @include centering;
}

</style>