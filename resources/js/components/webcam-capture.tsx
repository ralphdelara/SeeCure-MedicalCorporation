import React, { useRef, useState, useCallback } from 'react';
import Webcam from 'react-webcam';

// Define the dimensions and front-camera configuration
const videoConstraints: MediaTrackConstraints = {
    width: 1280,
    height: 720,
    facingMode: 'user', // 'user' for front camera, 'environment' for rear camera
};

interface WebcamCaptureProps {
    setImageData: (data: string | null) => void; // Using a clean, typed function instead of 'any'
}

export const WebcamCapture: React.FC<WebcamCaptureProps> = ({ setImageData }) => {
    // Explicitly type the ref to match the Webcam component instance
    const webcamRef = useRef<Webcam>(null);
    const [imgSrc, setImgSrc] = useState<string | null>(null);

    // Capture the photo from the stream
    const capture = useCallback(() => {
        if (webcamRef.current) {
            const imageSrc = webcamRef.current.getScreenshot();
            setImgSrc(imageSrc);
            setImageData(imageSrc);
        }
    }, [webcamRef]);

    // Reset the state to clear the captured photo and turn the camera back on
    const retake = () => {
        setImgSrc(null);
    };

    return (
        <div style={styles.container}>
            <div style={styles.webcamContainer}>
                {imgSrc === null ? (
                    /* Camera Preview Mode */
                    <>
                        <Webcam
                            audio={false}
                            ref={webcamRef}
                            screenshotFormat="image/jpeg"
                            videoConstraints={videoConstraints}
                            mirrored={true} // Mirrors the camera preview for a natural selfie view
                            style={styles.video}
                        />
                        <button onClick={capture} style={styles.captureBtn}>
                            Capture Photo
                        </button>
                    </>
                ) : (
                    /* Image Preview & Action Mode */
                    <>
                        <img src={imgSrc} alt="Captured preview" style={styles.video} />
                        <div style={styles.buttonGroup}>
                            <button onClick={retake} style={styles.retakeBtn}>
                                Retake Photo
                            </button>
                        </div>
                    </>
                )}
            </div>
        </div>
    );
};

// Basic inline styling for presentation
const styles: { [key: string]: React.CSSProperties } = {
    container: {
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        fontFamily: 'Arial, sans-serif',
        padding: '20px',
    },
    title: {
        marginBottom: '20px',
        color: '#333',
    },
    webcamContainer: {
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        backgroundColor: '#f0f0f0',
        borderRadius: '8px',
        padding: '15px',
        boxShadow: '0 4px 6px rgba(0,0,0,0.1)',
    },
    video: {
        borderRadius: '4px',
        maxWidth: '100%',
        height: 'auto',
        maxHeight: '600px',
    },
    captureBtn: {
        marginTop: '15px',
        padding: '10px 20px',
        fontSize: '16px',
        backgroundColor: '#007bff',
        color: '#fff',
        border: 'none',
        borderRadius: '4px',
        cursor: 'pointer',
    },
    buttonGroup: {
        display: 'flex',
        gap: '10px',
        marginTop: '15px',
    },
    retakeBtn: {
        padding: '10px 20px',
        fontSize: '16px',
        backgroundColor: '#6c757d',
        color: '#fff',
        border: 'none',
        borderRadius: '4px',
        cursor: 'pointer',
    },
    saveBtn: {
        padding: '10px 20px',
        fontSize: '16px',
        backgroundColor: '#28a745',
        color: '#fff',
        border: 'none',
        borderRadius: '4px',
        cursor: 'pointer',
    },
};
