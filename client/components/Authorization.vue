<script setup lang="ts">

// imports

import { ref } from 'vue';

import Input from './ui/Input.vue';

// state

const emailValue = ref<string>('');
const passwordValue = ref<string>('');

// functions

function submitForm() :void {

	const formData = new FormData();
	formData.set('email', emailValue.value);
	formData.set('password', passwordValue.value);

	$axios.post('/auth/login', formData).then(response => {

		const data = response.data;

		console.log(data);

	});

};

</script>

<template>
<div class="app-authorization">
	
	email - {{ emailValue }}
	password - {{ passwordValue }}

	<form
		class="app-authorization__form"
		@submit.prevent="submitForm"
	>
	
		<Input
			type="email"
			v-model="emailValue"
		/>

		<Input
			type="password"
			v-model="passwordValue"
		/>

		<button class="app-authorization__submit-button">Отправить</button>

	</form>
	
</div>
</template>

<style lang="scss">

</style>