<template>
  <div class="row mt-5">
    <div class="col-lg-5 m-auto">
      <img class="img-fluid d-block mb-4 mx-auto" width="200" src="/assets/img/logo.png"/>
      <div class="card">
        <h3 class="card-title text-center pt-3 pb-0">{{ $t('Login') }}</h3>
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <div class="card-body">
            <!-- Email -->
            <div class="form-group">
              <label class="form-label">{{ $t('email') }}</label>
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>

            <!-- Password -->
            <div class="form-group">
              <label class="form-label">{{ $t('password') }}</label>
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password" />
            </div>

            <!-- Remember Me -->
            <div class="form-group">
              <div class="d-flex">
                <checkbox v-model="remember" name="remember">
                  {{ $t('remember_me') }}
                </checkbox>
              </div>
            </div>
            <v-button :block="true" :loading="form.busy">
              {{ $t('login') }}
            </v-button>
            <router-link :to="{ name: 'password.request' }" class="btn btn-link btn-block">
              {{ $t('forgot_password') }}
            </router-link>

          </div>

        </form>
      </div>
      <router-link :to="{ name: 'register' }" class="btn btn-link btn-block mt-3">
          {{ $t('register') }}
      </router-link>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',
  layout: 'basic',
  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'order' })
    }
  }
}
</script>
