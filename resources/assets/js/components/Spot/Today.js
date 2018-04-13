import React, {Component, Fragment} from 'react';
import { Card } from '../Nuggets/Card';
import {MyContext} from '../Provider';

class Today extends Component{
    constructor(props) {
        super(props)
        this.state = {
            data: {},
            bShowRefresh: false
        }

        this.formatRefreshDate = this.formatRefreshDate.bind(this)
    }

    formatRefreshDate(timestring){
        if(timestring !== null) {
            let sameDay = false
            let formattedTime = null
            let today = new Date()
            let nowMonth = today.getMonth() + 1
            let nowDay = today.getDate()
            let nowYear = today.getFullYear()
            let d = new Date(JSON.parse(timestring))
            let month = d.getMonth() + 1
            let day = d.getDate()
            let year = d.getFullYear()
            let hour = d.getHours()
            let minutes = d.getMinutes()
            let timeOfDay = null
            if(hour > 12){
                hour = hour - 12
                timeOfDay = 'PM'
            } else timeOfDay = 'AM'
            if(minutes < 10){
                minutes = `0${minutes}`
            }
            let fullDate = `${month}/${day}/${year}`
            let dateNow = `${nowMonth}/${nowDay}/${nowYear}`
            if(fullDate === dateNow) sameDay = true
            if(sameDay) {
                formattedTime = `Today at ${hour}:${minutes} ${timeOfDay}`
            } else {
                formattedTime = `${fullDate} at ${hour}:${minutes} ${timeOfDay}`
            }
            return formattedTime
        }
    }

    render(){
        return(
            <MyContext.Consumer>
                {(context) => (
                    <Fragment>
                        <div className="card-deck">
                            <Card title="Surf" listItems={context.surfItems.today} background="bg-primary" hidden={context.state.cardsHidden}/>
                            <Card title="Weather" listItems={context.weatherItems.today} background="bg-warning" hidden={context.state.cardsHidden} />
                        </div>
                        <div className="text-center">
                            <p className="text-muted">Last Updated: {this.formatRefreshDate(context.lastUpdated)}</p>
                            {context.bShowRefresh ? <p className="text-muted mb-3"><i onClick={context.updateCard} className="fas fa-sync pointer"></i> refresh</p> : 'Data Is Updated Every Hour'}
                        </div>
                    </Fragment>
                )}
            </MyContext.Consumer>
        )
    }
}

export default Today;