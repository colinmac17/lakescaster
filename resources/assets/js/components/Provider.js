import React, { Component, Fragment } from 'react';
import { toggleDescription, getWeatherDescription } from '../reactHelpers';
import axios from "axios";

const MyContext = React.createContext();

export default class Provider extends Component{
    constructor(props){
        super(props)
        this.state = {
            apiPath: this.props.apiPath,
            path: this.props.path,
            data: null,
            date: this.props.date,
            name: this.props.name,
            description: this.props.description,
            surfItems: [],
            surfForecast: [],
            weatherItems: [],
            weatherForecast: [],
            cardsHidden: false,
            lastUpdated: null
        }

        this.getSurfItems = this.getSurfItems.bind(this);
        this.getWeatherItems = this.getWeatherItems.bind(this);
        this.updateCard = this.updateCard.bind(this);
        this.getUpdateDate = this .getUpdateDate.bind(this);
    }

    componentDidMount(){
        const path = this.state.apiPath
        const now = Date.now()
        const bHasUpdated = localStorage.getItem('dataUpdated') !== null ? true : false
        let then = null;
        let bUpdate = false;
        if(bHasUpdated){
            then = localStorage.getItem('dataUpdated');
            if((now - then) >= 3600000) bUpdate = true;
        }

        if(bUpdate) {
            axios.get(path)
                .then((res) => {
                    this.setState({data: res.data, lastUpdated: now})
                    this.getSurfItems()
                    this.getWeatherItems()
                    localStorage.setItem('dataUpdated', Date.now())
                    localStorage.setItem('data', JSON.stringify(res.data))
                    localStorage.setItem('surfingData', JSON.stringify(res.data.surfData));
                    localStorage.setItem('currentWeatherData', JSON.stringify(res.data.currentWeather));
                    localStorage.setItem('weatherForecastData', JSON.stringify(res.data.weatherForecast));
                }).catch(err => console.log(err))
        } else {
            this.setState({data: JSON.parse(localStorage.getItem('data')), lastUpdated: then})
            this.getSurfItems()
            this.getWeatherItems()
        }
    }

    updateCard(){
        const path = this.state.apiPath
        this.setState({cardsHidden: true})
        axios.get(path)
            .then((res) => {
                this.setState({data: res.data})
                this.getSurfItems()
                this.getWeatherItems()
                this.setState({cardsHidden: false})
            }).catch(err => console.log(err))
    }

    getSurfItems(){
        this.setState({
          surfItems: [
                  {
                      "title": "Surf Height",
                      "desc": this.state.data !== null ? `${parseFloat(this.state.data.surfData[0].sWaveHeight).toFixed(2)} feet` : '...Loading'
                  },
                  {
                      "title": "Surf Direction",
                      "desc": this.state.data !== null ? `${parseFloat(this.state.data.surfData[0].sWaveDirection).toFixed(2)} degrees` : '...loading'
                  },
                  {
                      "title": "Surf Period",
                      "desc": this.state.data !== null ? `${parseFloat(this.state.data.surfData[0].sWavePeriod).toFixed(2)} seconds` : '...loading'
                  }
              ],
            surfForecast: [

            ]
        })
    }

    getWeatherItems(){
        this.setState({
            weatherItems: [
                {
                    "title": "Temperature",
                    "desc": this.state.data !== null ? `${Math.round(this.state.data.currentWeather.iTemp)} °F ${getWeatherDescription(this.state.data.currentWeather.sDescription.trim())}` : '...Loading'
                },
                {
                    "title": "Wind Speed",
                    "desc": this.state.data !== null ? `${(this.state.data.currentWeather.iWindSpeed).toFixed(2)} meters/second` : '...Loading'
                },
                {
                    "title": "Wind Direction",
                    "desc": this.state.data !== null ? `${Math.round(this.state.data.currentWeather.iWindDirection)} degrees` : '...Loading'
                }
            ]
        })
    }

    getUpdateDate(timestamp){
        let d = new Date(timestamp)
        console.log(d)
    }

    render(){
        return(
            <MyContext.Provider
                value={{
                state: this.state,
                lastUpdated: this.getUpdateDate(this.state.lastUpdated),
                surfItems: {
                 today: this.state.surfItems,
                 forecast: this.state.surfForecast
                },
                weatherItems: {
                 today: this.state.weatherItems,
                 forecast: this.state.weatherForecast
                },
                updateCard: this.updateCard
            }}>
                {this.props.children}
            </MyContext.Provider>
        )
    }
}

export {MyContext};