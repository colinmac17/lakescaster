import React, {Component, Fragment} from 'react';
import { Card } from '../Nuggets/Card';
import {MyContext} from '../Provider';

class Today extends Component{
    constructor(props) {
        super(props)
        this.state = {
            data: {}
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
                            <p className="text-muted">Last Updated: {context.lastUpdated}</p>
                            <p className=""><i onClick={context.updateCard} className="fas fa-sync pointer"></i> refresh</p>
                        </div>
                    </Fragment>
                )}
            </MyContext.Consumer>
        )
    }
}

export default Today;