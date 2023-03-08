<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue';
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
const data = reactive({
    weather: null,
    error: null,
});
const getLocation = () => {
    navigator.geolocation.getCurrentPosition(
    position => {
        const { latitude, longitude } = position.coords;
        getWeather(latitude, longitude);
    },
    error => {
        data.error = 'Unable to retrieve your location';
    }
    );
    console.log('oka');
};
const getWeather = async (latitude, longitude) => {
    const apiKey = '8b50a6f9091dc435ad9179d7dbb8d667';
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=${apiKey}&units=metric`;

    try {
    const response = await fetch(apiUrl);
    const jsonData = await response.json();
    console.log(jsonData)
    const { weather } = jsonData;
    console.log(weather);
    data.weather = jsonData;
    } catch (error) {
    data.error = 'Unable to retrieve weather data';
    
    }
};
onMounted(()=>{
 getLocation();
 console.log("fired");
})
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>

        <div class="flex justify-center items-center">
  <div class="bg-gray-200 p-4 rounded-lg">
    <div class="text-2xl font-bold mb-2"><p v-if="data.weather">{{ data.weather.name }}</p></div>
    <div class="flex items-center">
      <img :src="'http://openweathermap.org/img/wn/' + (data.weather?.weather[0]?.icon) + '@2x.png'" alt="weather icon" class="w-12 h-12 mr-2">
      <div>
        <div class="text-3xl font-bold">{{data.weather?.main?.temp}} °C</div>
        <div class="text-sm text-gray-600"><p v-if="data.weather">{{ data.weather.weather[0]?.main }}</p></div>
        <p v-if="data.error">{{ data.error }}</p>
    
      </div>
    </div>
  </div>
</div>

    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
