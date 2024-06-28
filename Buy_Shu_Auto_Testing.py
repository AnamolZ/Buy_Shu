from selenium import webdriver
from selenium.webdriver.edge.service import Service as EdgeService
from selenium.webdriver.edge.options import Options as EdgeOptions
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

def init_driver():
    edge_options = EdgeOptions()
    return webdriver.Edge(service=EdgeService(), options=edge_options)

def wait_for_element(driver, by, value, timeout=10):
    return WebDriverWait(driver, timeout).until(EC.presence_of_element_located((by, value)))

def wait_and_click(driver, by, value, timeout=10):
    element = WebDriverWait(driver, timeout).until(EC.element_to_be_clickable((by, value)))
    element.click()
    return element

def handle_alert(driver, timeout=10):
    alert = WebDriverWait(driver, timeout).until(EC.alert_is_present())
    alert_text = alert.text
    alert.accept()
    return alert_text

def main():
    driver = init_driver()
    try:
        driver.get("http://localhost/")
        wait_for_element(driver, By.TAG_NAME, "body")
        print("Test Passed")
        time.sleep(3)

        driver.get("http://localhost/loginsignup/customerlogin.php")
        wait_for_element(driver, By.TAG_NAME, "body")
        time.sleep(3)

        wait_and_click(driver, By.CSS_SELECTOR, "a.toggle")
        print("Clicked Sign Up link")
        time.sleep(3)

        wait_for_element(driver, By.ID, "firstName").send_keys("Bina")
        time.sleep(3)
        wait_for_element(driver, By.ID, "lastName").send_keys("Pokhrel Dhakal")
        time.sleep(3)
        wait_for_element(driver, By.ID, "addressCustomer").send_keys("Biratnagar")
        time.sleep(3)
        wait_for_element(driver, By.ID, "customerEmail").send_keys("binaa@gmail.com")
        time.sleep(3)
        wait_for_element(driver, By.ID, "signupPassword").send_keys("bina12345")
        time.sleep(3)

        wait_and_click(driver, By.CSS_SELECTOR, "#signupForm .sign-btn")
        print("Clicked Sign Up button")
        time.sleep(3)

        alert_text = handle_alert(driver)
        customer_id_index = alert_text.find('Your Customer ID is: ') + len('Your Customer ID is: ')
        customer_id = alert_text[customer_id_index:]
        print(f"Customer ID: {customer_id}")
        time.sleep(3)

        driver.get("http://localhost/loginsignup/customerlogin.php")
        wait_for_element(driver, By.TAG_NAME, "body")
        time.sleep(3)

        wait_for_element(driver, By.ID, "customerId").send_keys(customer_id)
        time.sleep(3)
        wait_for_element(driver, By.ID, "password").send_keys("bina12345")
        time.sleep(3)

        wait_and_click(driver, By.CSS_SELECTOR, "#loginForm .sign-btn")
        print("Clicked Sign In button")
        time.sleep(3)

        alert_text = handle_alert(driver)
        print(f"Alert Text: {alert_text}")
        time.sleep(3)

        element = driver.find_element(By.CSS_SELECTOR, "a.addToCart")
        driver.execute_script("arguments[0].scrollIntoView(true);", element)
        time.sleep(3)

        wait_and_click(driver, By.CSS_SELECTOR, "a.addToCart")
        print("Clicked Buy button")
        time.sleep(3)

        alert_text = handle_alert(driver)
        print(f"Alert Text: {alert_text}")
        time.sleep(3)

        driver.get("http://localhost/shop/shop.php")
        wait_for_element(driver, By.TAG_NAME, "body")
        element = driver.find_element(By.CSS_SELECTOR, "button.add-to-cart")
        driver.execute_script("arguments[0].scrollIntoView(true);", element)
        time.sleep(3)

        add_to_cart_buttons = WebDriverWait(driver, 10).until(
            EC.presence_of_all_elements_located((By.CSS_SELECTOR, 'button.add-to-cart[data-productId][data-productName][data-stock][data-price]'))
        )

        count = 0
        for button in add_to_cart_buttons:
            button.click()
            time.sleep(2)

            try:
                alert_text = handle_alert(driver)
                print(f"Alert Text: {alert_text}")
            except Exception as e:
                print(f"No alert present or failed to handle alert: {str(e)}")

            time.sleep(2)
            count += 1
            if count >= 5:
                break

        time.sleep(3)

        driver.get("http://localhost/contact/contact.php")
        wait_for_element(driver, By.TAG_NAME, "body")
        wait_for_element(driver, By.ID, "full-name").send_keys("Bina Dhakal Pokhrel")
        time.sleep(1)
        wait_for_element(driver, By.ID, "email").send_keys("bina@gmail.com")
        time.sleep(1)
        wait_for_element(driver, By.ID, "message").send_keys("Hello, I am Bina Dhakal Pokhrel. I am testing the contact form.")
        time.sleep(1)

        wait_and_click(driver, By.CSS_SELECTOR, "button[type='submit']")

        alert_text = handle_alert(driver)
        print(f"Alert Text: {alert_text}")
        time.sleep(3)

        driver.get("http://localhost/checkout/checkout.php")
        wait_for_element(driver, By.TAG_NAME, "body")
        wait_for_element(driver, By.ID, "shipping-name")

        shipping_name_element = driver.find_element(By.ID, "shipping-name")
        shipping_address_element = driver.find_element(By.ID, "shipping-address")

        shipping_name = "John Doe"
        shipping_address = "123 Shipping Street, City, Country"

        print(f"Current Shipping Name: {shipping_name_element.text}")
        print(f"Current Shipping Address: {shipping_address_element.text}")

        wait_and_click(driver, By.ID, "edit-shipping")
        WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.ID, "shipping-form")))

        shipping_name_input = driver.find_element(By.ID, "shipping-name-input")
        shipping_name_input.clear()
        shipping_name_input.send_keys(shipping_name)

        shipping_address_input = driver.find_element(By.ID, "shipping-address-input")
        shipping_address_input.clear()
        shipping_address_input.send_keys(shipping_address)

        driver.find_element(By.ID, "submit-shipping").click()
        time.sleep(2)

        updated_shipping_name = shipping_name_element.text
        updated_shipping_address = shipping_address_element.text

        print(f"Updated Shipping Name: {updated_shipping_name}")
        print(f"Updated Shipping Address: {updated_shipping_address}")

        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.ID, "buy-button")))

        driver.find_element(By.ID, "buy-button").click()
        alert_text = handle_alert(driver)
        print(f"Alert Text: {alert_text}")
        time.sleep(3)

    except selenium.common.exceptions.NoSuchElementException as e:
        print(f"Element not found: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    main()
