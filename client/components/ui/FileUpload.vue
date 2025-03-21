<script setup lang="ts">

import { ref } from 'vue';
import { useEventListener, useToggle } from '@vueuse/core';

const isDropzoneVisible = ref<boolean>(false);
const dropzoneVisibilityToggle = useToggle(isDropzoneVisible);

useEventListener(document, 'dragenter', dragEnterHandler, { capture: true });
useEventListener(document, 'dragleave', dragEndHandler, { capture: true });

var eventsCounter: number = 0;

function onFileDrop(e:DragEvent) :void {

    async function getFileAsync(dataTranfer :DataTransfer) :Promise<File[]> {
        const files = [];
        for (var i = 0; i < dataTranfer.items.length; i++) {
            const item = dataTranfer.items[i];
            if (item.kind === 'file') {
                if (typeof item.webkitGetAsEntry === 'function'){
                    const entry = item.webkitGetAsEntry();
                    const entryContent = <File[]>await readEntryContentAsync(entry);
                    files.push(...entryContent);
                    continue;
                }

                const file = item.getAsFile();
                if (file) { files.push(file); }
            }
        }
        return files;
    };

    // Возвращает Promise со всеми файлами иерархии каталогов
    function readEntryContentAsync(entry:any) :Promise<File[]> {
        return new Promise((resolve, reject) => {

            let reading :number = 0;
            const contents :File[] = [];

            readEntry(entry);

            function readEntry(entry:any) {
                if (entry.isFile) {
                    reading++;
                    entry.file((file:File) => {
                        reading--;
                        contents.push(file);

                        if (reading === 0) {
                            resolve(contents);
                        }
                    });
                } else if (entry.isDirectory) {
                    readReaderContent(entry.createReader());
                }
            };

            function readReaderContent(reader:FileSystemDirectoryReader) {
                reading++;
                reader.readEntries(function(entries) {
                    reading--;
                    for (const entry of entries) {
                        readEntry(entry);
                    }
                    if (reading === 0) {
                        resolve(contents);
                    }
                });
            };
        });
    };

    eventsCounter = 0;
    isDropzoneVisible.value = false;

    getFileAsync(<DataTransfer>e.dataTransfer).then(filesUpload);

};

function fileInput(e:Event) :void {

    const input = <HTMLInputElement>e.target;
    const inputFiles = <FileList>input.files;

    const files :File[] = new Array();

    Array.prototype.forEach.call(inputFiles, function(file) {
        files.push(file);
    });

    filesUpload(files);

};

function filesUpload(files : File[]) :void {

    const formData = new FormData();

    Array.prototype.forEach.call(files, function(file) {
        formData.append('files[]', file, file.name);
    });

    $axios.post('/upload', formData).then(response => {

        const data = response.data;

        console.log(data);

    });

};

function dragEnterHandler(e:DragEvent) :boolean {

    e.preventDefault();
    eventsCounter++;

    isDropzoneVisible.value = true;

    return false;

};

function dragEndHandler(e:DragEvent) :boolean {

    e.preventDefault();
    eventsCounter--;

    if (eventsCounter <= 0)
        isDropzoneVisible.value = false;

    return false;

};

</script>

<template>
<div class="file-upload">

    <label role="button" class="file-upload__label">

        Загрузить файлы

        <input
            class="file-upload__input"
            type="file"
            multiple
            @input.prevent="fileInput"
        >

    </label>

    <div
        v-show="isDropzoneVisible"
        class="file-upload__dropzone"
        @dragover.prevent.stop
        @dragenter.prevent.stop
        @dragleave.prevent.stop
        @drop.prevent.stop="onFileDrop"
    >
        <div class="file-upload__dropzone-inner"></div>
    </div>

</div>
</template>

<style lang="scss">

.file-upload {

    padding: 12px;

    &__label {
        display: inline-block;
        font-weight: 600;
        padding: 8px 12px;
        border-radius: 4px;
        background-color: firebrick;
        color: white;
    }

    &__input {
        display: none;
    }

    &__dropzone {
        @include absolute-stretch;
        position: fixed;
        background-color: rgba(255, 255, 255, .8);
    }

    &__dropzone-inner {
        position: absolute;
        top: 20px;
        right: 20px;
        bottom: 20px;
        left: 20px;
        border: 6px dashed;
        border-radius: 12px;
    }

}

</style>