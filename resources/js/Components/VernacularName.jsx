import { useState, useEffect } from "react";
import Translation from "./Translation";

const VernacularName = ({ species_key, getVernacularName , language}) => {
    const [text, setText] = useState("");

    const onLoad = async () => {
        let name = await getVernacularName(species_key);
        setText(name);
    };

    useEffect(() => {
        onLoad();
    }, []);
    if (language == "EN") return <span>{text || "Loading..."}</span>;
    else if (language == "TH" && text ) return <Translation text={text}></Translation>;
    else return <span>{ "Loading..."}</span>;
};

export default VernacularName;
