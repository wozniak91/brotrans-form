<template>
  <card :title="$t('your_password')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('password_updated')" />

      <!-- Password -->
      <div class="form-group">
        <label class="form-label">{{ $t('new_password') }}</label>
        <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
        <has-error :form="form" field="password" />
      </div>
      
      <!-- Password Confirmation -->
      <div class="form-group">
        <label class="form-label">{{ $t('confirm_password') }}</label>
        <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
        <has-error :form="form" field="password_confirmation" />
      </div>

      <!-- Submit Button -->
      <div class="d-flex justify-content-end">
        <v-button :loading="form.busy" type="success">
          {{ $t('update') }}
        </v-button>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update () {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    }
  }
}
</script>
