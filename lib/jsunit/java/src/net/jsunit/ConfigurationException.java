package net.jsunit;

public class ConfigurationException extends Exception {
    private String propertyInError;
    private String invalidValue;

    public ConfigurationException(String property, String invalidValue, Exception exception) {
        super(exception);
        this.propertyInError = property;
        this.invalidValue = invalidValue;
    }

    public String getPropertyInError() {
        return propertyInError;
    }

    public String getInvalidValue() {
        return invalidValue;
    }
}
