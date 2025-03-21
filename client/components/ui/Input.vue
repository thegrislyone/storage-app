<script setup lang="ts">

// imports

import { ref, computed } from 'vue';
import { useFocus } from '@vueuse/core';


// meta

const { type = 'text', placeholder, modelValue } = defineProps<{
	type: string,
    placeholder: string,
	modelValue: string
}>();

const emit = defineEmits<{
  'update:modelValue': [value: string]
}>();

// dom

const $inputEl = ref<HTMLInputElement | null>(null);

// state

const { focused: isFocused } = useFocus($inputEl, { initialValue: false });

const localValue = computed<string>({
	get: (): string => modelValue,
	set(value: string) { emit('update:modelValue', value); }
});

// methods



</script>

<template>
<div class="app-input-wrapper">

    <div class="app-input">

        <input
            ref="$inputEl"
            class="app-input__field"
            :class="{
                'app-input__field_filled': localValue
            }"
            :type="type"
            v-model="localValue"
        >

        <label
            class="app-input__placeholder"
            :class="{
                'app-input__placeholder_top-position': isFocused || localValue
            }"
        >{{ placeholder }}</label>

    </div>

</div>
</template>

<style lang="scss">

.app-input-wrapper {
    position: relative;
    width: 100%;
}

.app-input {

    position: relative;

    &__field {

        display: block;
        width: 100%;
        font-size: 14px;
        line-height: 20px;
        outline: 2px solid gray;
        outline-offset: -2px;
        border-radius: 4px;
        padding: 12px 20px;
        @include transition;

        @include hocus {
            outline-color: gainsboro;
        }

        &_filled {
            outline-color: black;
        }

    }

    &__placeholder {

        position: absolute;
        font-size: 14px;
        line-height: 20px;
        left: 20px;
        top: calc(50% - 20px / 2);

        @include transition;

        &_top-position {
            padding: 0 2px;
            background: linear-gradient(0deg, transparent 8px, white 8px, white 10px, transparent 10px);
            top: -10px;
            left: 12px;
        }

    }

}

</style>