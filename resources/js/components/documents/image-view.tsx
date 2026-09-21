import { PhotoProvider, PhotoView } from 'react-photo-view';
import 'react-photo-view/dist/react-photo-view.css';

const ImageView = ({ url }: { url: string }) => {
    return (
        <PhotoProvider>
            <PhotoView src={url}>
                <img
                    src={url}
                    alt={`Thumbnail`}
                    style={{
                        width: '200px',
                        height: '150px',
                        objectFit: 'cover',
                        cursor: 'pointer',
                        borderRadius: '4px',
                        boxShadow: '0 2px 8px rgba(0,0,0,0.1)',
                    }}
                />
            </PhotoView>
        </PhotoProvider>
    );
};

export default ImageView;
