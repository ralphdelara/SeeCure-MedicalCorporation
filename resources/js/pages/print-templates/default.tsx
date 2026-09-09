import { useEffect } from "react";
import Footer from "./footer";
import Header from "./header";

const Default = () => {
    useEffect(() => {
        document.body.style.margin = "0";
        window.print();
    }, []);
    return (
        <>
        <Header/>
        Default
        <Footer/>
        </>
    );
}

export default Default;