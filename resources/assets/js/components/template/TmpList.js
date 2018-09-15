import React from 'react';
import Tmp from "./Tmp";

const TmpList = props => {
    return(
            <list>
                {props.propname.map(function(item) {
                    return (
                        <listitem key={item.id}>
                            <Tmp propname={item} />
                        </listitem>
                    );
                })}
            </list>
        );
}

export default TmpList;
