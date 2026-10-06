const FormHeader = ({ children }: {children: React.ReactNode}) => {
    return (
        <div className="badge bg-success w-100 mt-2 mb-2">
            <h5 className="mb-0 text-white fw-bolder">{children}</h5>
        </div>
    );
}

export default FormHeader;