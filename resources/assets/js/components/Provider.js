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
            data: (localStorage.getItem(`${this.props.name}-data`) !== null) ? JSON.parse(localStorage.getItem(`${this.props.name}-data`)) : null,
            date: this.props.date,
            name: this.props.name,
            bUser: this.props.bUser,
            description: this.props.description,
            surfItems: [],
            surfForecast: [],
            weatherItems: [],
            weatherForecast: [],
            cardsHidden: false,
            lastUpdated: null,
            bShowRefresh: false
        }

        this.getSurfItems = this.getSurfItems.bind(this);
        this.getWeatherItems = this.getWeatherItems.bind(this);
        this.updateCard = this.updateCard.bind(this);
        this.updateLocalStorage = this.updateLocalStorage.bind(this)
        this.formatDirection = this.formatDirection.bind(this)
        this.formatWaveHeight = this.formatWaveHeight.bind(this)
    }

    componentDidMount(){
        const path = this.state.apiPath
        const now = Date.now()
        const bHasUpdated = localStorage.getItem(`${this.props.name}-dataUpdated`) !== null ? true : false
        let then = null;
        let bUpdate = true;
        if(bHasUpdated){
            then = localStorage.getItem(`${this.props.name}-dataUpdated`);
            if((now - then) >= 3600000) {
                bUpdate = true;
                this.setState({bShowRefresh: true})
            }
            else {
                this.setState({bShowRefresh: false})
                bUpdate = false;
            }
        }

        if(bUpdate) {
            axios.get(path)
                .then((res) => {
                    this.setState({data: res.data, lastUpdated: now, bShowRefresh: false})
                    this.getSurfItems()
                    this.getWeatherItems()
                    this.updateLocalStorage(res)
                }).catch(err => console.log(err))
        } else {
            this.getSurfItems()
            this.getWeatherItems()
            this.setState({lastUpdated: JSON.parse(localStorage.getItem(`${this.props.name}-dataUpdated`))})
        }
    }

    updateLocalStorage(res){
        localStorage.setItem(`${this.props.name}-dataUpdated`, JSON.stringify(Date.now()))
        localStorage.setItem(`${this.props.name}-data`, JSON.stringify(res.data))
    }

    updateCard(){
        const path = this.state.apiPath
        this.setState({cardsHidden: true})
        axios.get(path)
            .then((res) => {
                this.setState({data: res.data, lastUpdated: Date.now(), cardsHidden: false})
                this.getSurfItems()
                this.getWeatherItems()
                this.updateLocalStorage(res)
            }).catch(err => console.log(err))
    }

    formatWaveHeight(iHeight){
        let lowNum = Math.floor(iHeight)
        let highNum = lowNum + 1
        return `${lowNum}-${highNum}`
    }

    getSurfItems(){
        this.setState({
          surfItems: [
                  {
                      "title": "Wave Height",
                      "desc": this.state.data !== null ? `${this.formatWaveHeight(parseFloat(this.state.data.surfData[0].sWaveHeight).toFixed(2))} feet` : '...Loading'
                  },
                  {
                      "title": "Wave Direction",
                      "desc": this.state.data !== null ? `${this.formatDirection(this.state.data.surfData[0].sWaveDirection)}` : '...loading'
                  },
                  {
                      "title": "Wave Period",
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
                    "title": "Air Temperature",
                    "desc": this.state.data !== null ? `${Math.round(this.state.data.currentWeather.iTemp)} °F ${getWeatherDescription(this.state.data.currentWeather.sDescription.trim())}` : '...Loading'
                },
                {
                    "title": "Water Temperature",
                    "desc": this.state.data !== null ? `${parseFloat(Math.round(this.state.data.surfData[0].iCurrentWaterTemp))} °F` : '...Loading'
                },
                {
                    "title": "Wind Speed",
                    "desc": this.state.data !== null ? `${(this.state.data.currentWeather.iWindSpeed).toFixed(2)} (m/s) - ${this.formatDirection(this.state.data.currentWeather.iWindDirection)}` : '...Loading'
                }
            ]
        })
    }

    formatDirection(iDirection){
        if(iDirection >= 10 && iDirection < 80){
            return 'NE'
        } else if (iDirection >=80 && iDirection <100){
            return 'E'
        } else if (iDirection >= 100 && iDirection < 170){
            return 'SE'
        } else if (iDirection >=170 && iDirection < 190){
            return 'S'
        } else if (iDirection >=190 && iDirection < 260){
            return 'SW'
        } else if (iDirection >= 260 && iDirection < 280){
            return 'W'
        } else if (iDirection >= 280 && iDirection < 350){
            return 'NW'
        } else return 'N'
    }

    render(){
        return(
            <MyContext.Provider
                value={{
                state: this.state,
                lastUpdated: this.state.lastUpdated,
                surfItems: {
                 today: this.state.surfItems,
                 forecast: this.state.surfForecast
                },
                weatherItems: {
                 today: this.state.weatherItems,
                 forecast: this.state.weatherForecast
                },
                updateCard: this.updateCard,
                bShowRefresh: this.state.bShowRefresh
            }}>
                {this.props.children}
            </MyContext.Provider>
        )
    }
}

export {MyContext};