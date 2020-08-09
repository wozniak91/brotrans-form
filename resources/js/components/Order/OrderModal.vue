<template>
<div :class="['modal', 'fade', { 'show' : active }]" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $t('add_product') }}</h5>
        <button type="button" class="close" data-dismiss="modal" @click="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">

          <!-- name -->
          <div class="form-group col-12">
            <label class="form-label">{{ $t('name') }}</label>
            <input v-model.trim="$v.name.$model" :class="{ 'is-invalid': $v.name.$error }" class="form-control" type="text" name="name" :placeholder="$t('corner_sofa')">
            <div class="help-block invalid-feedback" :class="{ 'd-blick': $v.name.$error }" v-if="!$v.name.required">{{ $t('product_name_is_required') }}</div>
          </div>

          <!-- weight -->
          <div class="form-group col-12 col-md-4">
            <label class="form-label">{{ $t('weight') }}</label>
            <div class="input-group">
              <input v-model.trim="$v.weight.$model" min="1" :class="{ 'is-invalid': $v.weight.$error }" class="form-control" type="number" name="weight">
              <div class="input-group-append">
                <span class="input-group-text">kg</span>
              </div>
            </div>
            <div class="help-block invalid-feedback" :class="{ 'd-block': $v.weight.$error }" v-if="!$v.weight.required">{{ $t('weight_is_required') }}</div>
          </div>

          <!-- price -->
          <div class="form-group col-12 col-md-4">
            <label class="form-label">{{ $t('price') }}</label>
            <div class="input-group">
              <input v-model.trim="$v.price_brutto.$model" :class="{ 'is-invalid': $v.price_brutto.$error }" min="0" class="form-control" type="number" name="price_brutto">
              <div class="input-group-append">
                <span class="input-group-text">zł</span>
              </div>
            </div>
            <div class="help-block invalid-feedback" :class="{ 'd-block': $v.price_brutto.$error }" v-if="!$v.price_brutto.required">{{ $t('price_is_required') }}</div>
          </div>

          <!-- quantity -->
          <div class="form-group col-12 col-md-4">
            <label class="form-label">{{ $t('quantity') }}</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <button class="input-group-text" type="button" @click="quantityDown"><fa icon="minus" fixed-width /></button>
              </div>
              <input v-model.trim="$v.quantity.$model" min="1" :class="{ 'is-invalid': $v.quantity.$error }" class="form-control text-center" type="number" name="quantity">
              <div class="input-group-append">
                <button class="input-group-text" type="button" @click="quantityUp"><fa icon="plus" fixed-width /></button>
              </div>
            </div>
            <div class="help-block invalid-feedback" :class="{ 'd-block': $v.quantity.$error }" v-if="!$v.quantity.required">{{ $t('quantity_is_required') }}</div>
          </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" @click="close">{{ $t('close') }}</button>
        <button type="button" class="btn btn-primary" @click="addProduct">{{ $t('add') }}</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import { v4 as uuidv4 } from 'uuid';
import { required, minLength, numeric, minValue } from 'vuelidate/lib/validators'

export default {
  name: 'OrderModal',
  props: {
    active: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    uuid: uuidv4(),
    name: '',
    price_brutto: '',
    tax_rate: 23,
    quantity: 1,
    weight: ''
  }),
  validations: {
    name: {
      required,
      minLength: minLength(4)
    },
    price_brutto: {
      required,
      numeric
    },
    quantity: {
      required,
      numeric,
      minValue: minValue(1)
    },
    weight: {
      required,
      numeric
    }
  },
  methods: {
    addProduct() {
      
      this.$v.$touch()
      if(!this.$v.$anyError) {
        // add product to order
        this.$emit('addProduct', this.$data)
      }
    },
    close() {
      this.$emit('update:active', false)
    },
    quantityUp() {
      this.quantity = parseInt(this.quantity) + 1;
    },
    quantityDown() {
      this.quantity = this.quantity > 1 ? this.quantity-1 : this.quantity;
    }
  }
}
</script>


<style lang="scss">
@import './../../../sass/_variables.scss';

</style>