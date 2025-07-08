<template>
  <transition name="offcanvas-fade">
    <div v-if="modelValue" class="fixed inset-0 z-50 flex" @keydown.esc="close()">
      <!-- Overlay -->
      <div class="fixed inset-0 bg-black/40 transition-opacity" @click="close()"></div>
      <!-- Offcanvas Panel -->
      <div
        class="fixed bg-white shadow-xl w-full max-w-lg h-full transition-transform duration-300 ease-in-out right-0 top-0 md:translate-x-0 md:w-lg md:rounded-l-lg md:shadow-2xl md:h-full md:bottom-auto md:right-0 md:top-0 md:fixed md:transition-transform md:duration-300 md:ease-in-out md:z-50 translate-y md:translate-y-0"
        :class="{
          'translate-x-0': isDesktop,
          'translate-x-full': isDesktop && !modelValue,
          'translate-y-0': !isDesktop,
          'translate-y-full': !isDesktop && !modelValue,
        }"
        ref="panel"
        tabindex="-1"
      >
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-800">{{ contact ? 'Editing Contact ' + contact.name : 'New Contact' }}</h2>
          <button @click="close()" class="text-gray-400 hover:text-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="p-6 overflow-y-auto h-[calc(100vh-64px)]">
          <form @submit.prevent="submitForm">
              <div class="grid gap-6 mb-6 grid-cols-1">
                  <div>
                      <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                      <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="John" required v-model="form.name" />
                  </div>
                  <div>
                      <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone number</label>
                      <input type="tel" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="+55 (11) 11111-1111" required v-model="form.phone" />
                  </div>
              </div>
              <div class="mb-6">
                  <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email address</label>
                  <input type="email" id="email" class="read-only:bg-gray-200 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="john.doe@company.com" v-model="form.email" :readonly="contact"/>
              </div> 
              <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">{{ contact ? 'Update Contact' : 'Add Contact'}}</button>
          </form>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import Swal from 'sweetalert2'
import { ref, onMounted, onUnmounted, watch, reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  modelValue: { type: Boolean, required: true },
  contact: { type: Object, default: null, required: false },
})

const form = useForm({
  name: null,
  phone: null,
  email: null,
})

function submitForm() {
  if (props.contact) {
    delete form.email // Make email readonly if editing an existing contact
    form.put(`/contacts/${props.contact.id}`, {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire({
          icon: 'success',
          title: 'Contact updated successfully',
          showConfirmButton: false,
          timer: 1500,
        })
      },
      onError: (errors) => {
        Swal.fire({
          icon: 'error',
          title: 'Error updating contact',
          text: Object.values(errors).flat().join(', ') || 'Something went wrong',
        })
      },
    })
  } else {
    form.post('/contacts', {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire({
          icon: 'success',
          title: 'Contact added successfully',
          showConfirmButton: false,
          timer: 1500,
        })
      },
      onError: (errors) => {
        Swal.fire({
          icon: 'error',
          title: 'Error adding contact',
          text: Object.values(errors).flat().join(', ') || 'Something went wrong',
        })
      },
    })
  }
  close()
}

const emit = defineEmits(['update:modelValue', 'close'])

const isDesktop = ref(window.innerWidth >= 768)

function handleResize() {
  isDesktop.value = window.innerWidth >= 768
}

watch(() => props.modelValue, (newValue) => {
  if (newValue) {
    document.body.style.overflow = 'hidden'
    form.name = props.contact ? props.contact.name : ''
    form.phone = props.contact ? props.contact.phone : ''
    form.email = props.contact ? props.contact.email : ''
  } else {
    document.body.style.overflow = ''
  }
})

function close() {
  emit('update:modelValue', false)
  emit('close')
}

onMounted(() => {
  window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
  emit('update:modelValue', false)
  emit('close')
})
</script>

<style scoped>
.offcanvas-fade-enter-active,
.offcanvas-fade-leave-active {
  transition: opacity 0.2s;
}
.offcanvas-fade-enter-from,
.offcanvas-fade-leave-to {
  opacity: 0;
}
</style>