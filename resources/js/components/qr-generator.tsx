import React, { useState } from 'react';
import QRCode from 'react-qr-code';

const QRCodeGenerator = ({ content, size }: { content: string; size: number }) => {
    const [text] = useState(content);

    return (
        <div
            style={{
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
                gap: '20px',
                padding: '20px',
            }}
        >
            {/* QR Code Container */}
            <div style={{ background: 'white', padding: '16px', borderRadius: '8px' }}>
                <QRCode value={text} size={size} bgColor="#ffffff" fgColor="#000000" level="H" />
            </div>
        </div>
    );
};

export default QRCodeGenerator;
