// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
	compatibilityDate: '2024-11-01',
	devtools: { enabled: true },
	vite: {
		server: {
			allowedHosts: ['storage-app.local']
		},
		css: {
            preprocessorOptions: {
                scss: {
                    additionalData: `
                        @use "@/assets/scss/variables.scss" as *;
                        @use "@/assets/scss/mixins.scss" as *;
                    `
                }
            }
        }
	},
	typescript: {
		typeCheck: true,
		strict: true
	},	
	css: [
		'~/assets/scss/reset.scss',
		'~/assets/scss/base.scss',
		'~/assets/scss/fonts.scss'
	]
})
