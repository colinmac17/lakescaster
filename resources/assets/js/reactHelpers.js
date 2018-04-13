import React from 'react';

// Method to clean up numbers

//Method to check for and store data in local storage

export const getWeatherDescription = (sDesc) => {
    switch(sDesc){
        case 'few clouds':
            return `with a ${sDesc}`
            break;
        case 'clear sky':
            return `with a ${sDesc}`
            break;
        case 'scattered clouds':
            return `with ${sDesc}`
            break;
        case 'broken clouds':
            return `with ${sDesc}`
            break;
        case 'shower rain':
            return `with rain showers`
            break;
        case 'thunderstorm':
            return `with thunderstorms`
            break;
        default:
            return `and ${sDesc}y`
            break;
    }
}