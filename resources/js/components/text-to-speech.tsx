import React, { useState } from 'react';

const TextToSpeech = () => {
    const [text, setText] = useState('');

    const handleSpeak = () => {
        if (!text) return;
        const utterance = new SpeechSynthesisUtterance(text);
        window.speechSynthesis.speak(utterance);
    };

    return (
        <div>
            <textarea
                value={text}
                onChange={(e) => setText(e.target.value)}
                placeholder="Type something here..."
            />
            <button onClick={handleSpeak}>Play Voice</button>
        </div>
    );
}

export default TextToSpeech;
