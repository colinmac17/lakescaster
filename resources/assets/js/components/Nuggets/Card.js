import React, {Fragment} from 'react';

export const Card = (props) => {
    let className = 'card spot-card mb-3';
    if(props.background) className += ` ${props.background}`
    return(
        <Fragment>
            {!props.hidden ?
                <div className={className}>
                    <div className="card-header text-white text-center">
                        {props.title ? props.title : 'Title'}
                    </div>
                    <ul className="list-group list-group-flush">
                        {props.listItems.length > 0 ? props.listItems.map((item, i) => {
                                return (
                                    <li key={i} className="list-group-item">{item.title}: {item.desc}</li>
                                )
                            }) :
                            <Fragment>
                                <li className="list-group-item">...loading</li>
                                <li className="list-group-item">...loading</li>
                                <li className="list-group-item">...loading</li>
                            </Fragment>
                        }
                    </ul>
                </div>
                : <div className="card spot-card no-border mb-3">
                    <p className="text-center"><i className="fas fa-spinner fa-spin fa-7x"></i></p>
                </div>
            }
        </Fragment>
    )
}