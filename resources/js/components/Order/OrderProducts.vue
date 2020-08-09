<template>
  <div class="OrderProducts">
  
    <order-product v-for="product in products" :product="product" :key="product.uuid" @removeProduct="removeProduct" />

    <div class="alert alert-light mt-3" role="alert" v-if="!products.length">
      {{ $t('no_products') }}
    </div>

    <transition name="page">
      <order-modal v-if="showModal" :active.sync="showModal" @addProduct="addProduct" />
    </transition>

    <div class="d-flex justify-content-end pt-4">
      <button class="btn btn-outline-primary" type="button" @click="showModal = !showModal">
        <fa icon="plus" fixed-width /> {{ $t('add_product') }}
      </button>
    </div>

  </div>
</template>

<script>

import OrderModal from './OrderModal'
import OrderProduct from './OrderProduct'

export default {
  name: 'OrderProducts',
  components: {
    OrderModal,
    OrderProduct
  },
  data: () => ({
    showModal: false,
  }),
  props: {
    products: {
      type: Array,
      default: null
    }
  },
  methods: {
    addProduct(product) {
      this.$emit('addProduct', product)
      this.showModal = false;
    },
    removeProduct(uuid) {
      this.$emit('removeProduct', uuid)
    }
  }
}
</script>

<style lang="scss">

@import './../../../sass/_variables.scss';

.show {
  display: block;
}

.OrderProducts {

  &__button {
    padding: $btn-padding-y $btn-padding-x;
    border-radius: $border-radius;
    font-weight: $btn-font-weight;
    border: 1px solid $gray-400;
    background:  $gray-200;
    color: $body-color;
    line-height: 1;
  }
}
</style>