<script lang="ts" setup>

// imports

import FileUpload from '~/components/ui/FileUpload.vue';

// meta

definePageMeta({
    middleware: ['auth']
});

// methods

function fileUploaded(e: Event) :void {

    const input = <HTMLInputElement>e.target;
    const inputFiles = <FileList>input.files;

    const formData = new FormData();

    Array.prototype.forEach.call(inputFiles, function(file) {
        formData.append('files[]', file, file.name);
    });

    $axios.post('/upload', formData).then(response => {

        const data = response.data;

        console.log(data);

    });

};

function buttonClick() {

    const formData = new FormData();

    $axios.post('/upload', formData).then(response => {

        const data = response.data;

        console.log(data);

    });

};

</script>

<template>
<main class="page-index">

    <FileUpload/>

</main>
</template>

<style lang="scss">



</style>
