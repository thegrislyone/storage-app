<script setup lang="ts">

// imports

import { ref, computed } from 'vue';

// meta

const { type = 'text', modelValue } = defineProps<{
	type: string,
	modelValue: string
}>();

const emit = defineEmits<{
  'update:modelValue': [value: string]
}>();

// state

const localValue = computed<string>({
	get: (): string => modelValue,
	set(value: string) { emit('update:modelValue', value); }
});

</script>

<template>
<div class="app-input-wrapper">

	<input
		class="app-input"
		:type="type"
		v-model="localValue"
	>

</div>
</template>

<style lang="scss">

.app-input-wrapper {

}

.app-input {
	display: block;
	font-size: 14px;
	line-height: 20px;
	border: 1px solid;
}

</style>