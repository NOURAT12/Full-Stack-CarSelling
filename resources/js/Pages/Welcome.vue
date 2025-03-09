<template>
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-4">

      <h1 class="animated-text mb-8 text-center">
        Welcome to Tiger Cars
      </h1>
      <div class="flex space-x-6">
        <Link
          :href="route('login')"
          method="get"
          as="button"
          type="button"
          class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition duration-300"
        >
          Login
        </Link>
        <Link
          :href="route('register')"
          method="get"
          as="button"
          type="button"
          class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md transition duration-300"
        >
          Register
        </Link>
      </div>
    </div>
  </template>

  <script>
  import { Link } from '@inertiajs/vue3';

  export default {
    name: 'Welcome',
    components: {
      Link,
    },
  };
  </script>

  <style scoped>
  .animated-text {
    font-size: 4rem;
    font-weight: bold;
    text-transform: uppercase;
    text-align: center;


    background: url('/images/car.jpg') no-repeat;
    background-size: 300% auto;
    background-position: 0% 50%;
    -webkit-background-clip: text;
    color: transparent;

    animation: moveBackground 6s ease-in-out infinite alternate;
  }

  @keyframes moveBackground {
    0% {
      background-position: 0% 50%;
    }
    100% {
      background-position: 100% 50%;
    }
  }
  </style>
