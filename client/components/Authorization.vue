<script setup lang="ts">

// imports

import { ref } from 'vue';

import Input from './ui/Input.vue';

// state

const isRegistration = ref<boolean>(false);
const isLogin = ref<boolean>(true);

const nameValue = ref<string>('');
const emailValue = ref<string>('');
const passwordValue = ref<string>('');

// functions

function loginFormSubmit() :void {

	const formData = new FormData();
	formData.set('email', emailValue.value);
	formData.set('password', passwordValue.value);

	$axios.post('/auth/login', formData).then(response => {
		const data = response.data;
		console.log(data);
	});

};

function registrationFormSubmit() :void {

    const formData = new FormData();
    formData.set('name', nameValue.value);
	formData.set('email', emailValue.value);
	formData.set('password', passwordValue.value);

    $axios.post('/auth/registration', formData).then(response => {
        const data = response.data;
        console.log(data);
    });

};

function switchForms() :void {
    isLogin.value = !isLogin.value;
    isRegistration.value = !isRegistration.value;
};

</script>

<template>
<div class="app-authorization">

    <form
        v-if="isRegistration"
        key="registration-form"
        class="app-authorization__registration-form"
        @submit.prevent="registrationFormSubmit"
    >

        <fieldset class="app-authorization__fields">

            <legend class="app-authorization__form-headline">Регистрация</legend>

            <div class="app-authorization__fields-grid">

                <Input
                    type="text"
                    placeholder="Имя"
                    v-model="nameValue"
                />

                <Input
                    type="email"
                    placeholder="Email"
                    v-model="emailValue"
                />

                <Input
                    type="password"
                    placeholder="Пароль"
                    v-model="passwordValue"
                />

            </div>

        </fieldset>

        <button class="app-authorization__submit-button">Отправить</button>

    </form>

    <form
        v-else-if="isLogin"
        key="login-form"
        class="app-authorization__login-form"
        @submit.prevent="loginFormSubmit"
    >

        <fieldset class="app-authorization__fields">

            <legend class="app-authorization__form-headline">Авторизация</legend>

            <div class="app-authorization__fields-grid">

                <Input
                    type="email"
                    placeholder="Email"
                    v-model="emailValue"
                />

                <Input
                    type="password"
                    placeholder="Пароль"
                    v-model="passwordValue"
                />

            </div>

        </fieldset>

        <button class="app-authorization__submit-button">Отправить</button>

    </form>

    <button
        type="button"
        class="app-authorization__forms-switch-button"
        @click="switchForms"
    >
        <template v-if="isLogin">Зарегистироваться</template>
        <template v-else-if="isRegistration">Авторизоваться</template>
    </button>

</div>
</template>

<style lang="scss">

.app-authorization {

    &__form-headline {
        font-size: 32px;
        line-height: 1em;
        margin-bottom: 20px;
        text-align: center;
    }

    &__fields-grid {
        display: grid;
        grid-template-columns: 1fr;
        grid-gap: 28px;
    }

}

</style>